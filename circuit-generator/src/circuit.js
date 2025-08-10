// Generate a closed circuit using a simple backtracking algorithm.
// The search attempts to build the longest circuit possible without
// exceeding `maxPieces` while respecting the user's collection.
// Throws an error if a closed circuit cannot be produced or if the
// collection does not contain the minimum number of curve pieces.
function generateCircuit(collection, maxPieces = 4) {
  const curves = collection.curve || 0;
  if (curves < 4 || maxPieces < 4) {
    throw new Error('Need at least 4 curve pieces to generate a circuit');
  }

  // Available piece definitions used by the algorithm.
  const pieces = {
    'straight-short': { id: 'straight-short', type: 'straight', length: 1 },
    'straight-long': { id: 'straight-long', type: 'straight', length: 2 },
    curve: { id: 'curve', type: 'curve', turn: 90, length: 1 },
  };

  // Clone inventory so we can mutate counts during search.
  const inventory = { ...collection };

  // Orientation is expressed in degrees: 0=E, 90=N, 180=W, 270=S.
  const step = (piece, pos) => {
    let { x, y, dir } = pos;
    const rad = (dir * Math.PI) / 180;
    const dx = Math.round(Math.cos(rad));
    const dy = Math.round(Math.sin(rad));

    switch (piece.id) {
      case 'straight-short':
        x += dx;
        y += dy;
        break;
      case 'straight-long':
        x += 2 * dx;
        y += 2 * dy;
        break;
      case 'curve':
        x += dx;
        y += dy;
        dir = (dir + 90) % 360; // fixed right turn
        break;
      default:
        return null;
    }

    return { x, y, dir };
  };

  let bestCircuit = null;

  const search = (pos, path, visited, depth) => {
    // Valid closed loop found
    if (depth >= 4 && pos.x === 0 && pos.y === 0 && pos.dir === 0) {
      if (!bestCircuit || depth > bestCircuit.length) {
        bestCircuit = path.slice();
      }
      return;
    }

    if (depth === maxPieces) {
      return; // can't add more pieces
    }

    for (const id of Object.keys(pieces)) {
      if (!inventory[id]) continue;
      const nextPos = step(pieces[id], pos);
      if (!nextPos) continue;
      const key = `${nextPos.x},${nextPos.y}`;
      if (key !== '0,0' && visited.has(key)) continue;

      inventory[id]--;
      path.push({ id });
      visited.add(key);
      search(nextPos, path, visited, depth + 1);
      visited.delete(key);
      path.pop();
      inventory[id]++;
    }
  };

  search({ x: 0, y: 0, dir: 0 }, [], new Set(['0,0']), 0);

  if (!bestCircuit) {
    throw new Error('Unable to generate a closed circuit with the provided pieces');
  }
  return bestCircuit;
}

// Serialize circuit structure into a compact base64url hash.
function serializeCircuit(circuit) {
  return Buffer.from(JSON.stringify(circuit)).toString('base64url');
}

// Deserialize a circuit from its base64url hash representation.
function deserializeCircuit(hash) {
  return JSON.parse(Buffer.from(hash, 'base64url').toString('utf8'));
}

module.exports = {
  generateCircuit,
  serializeCircuit,
  deserializeCircuit,
};
