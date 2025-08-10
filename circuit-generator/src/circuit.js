function generateCircuit(collection, maxPieces = 4) {
  const available = collection.curve || 0;
  if (available < 4 || maxPieces < 4) {
    throw new Error('Need at least 4 curve pieces to generate a circuit');
  }
  return Array(4).fill({ id: 'curve' });
}

function serializeCircuit(circuit) {
  return Buffer.from(JSON.stringify(circuit)).toString('base64url');
}

function deserializeCircuit(hash) {
  return JSON.parse(Buffer.from(hash, 'base64url').toString('utf8'));
}

module.exports = {
  generateCircuit,
  serializeCircuit,
  deserializeCircuit,
};
