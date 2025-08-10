// Generate a minimal closed circuit using four curve pieces.
// Throws an error if the collection lacks sufficient pieces or maxPieces < 4.
function generateCircuit(collection, maxPieces = 4) {
  const available = collection.curve || 0;
  if (available < 4 || maxPieces < 4) {
    throw new Error('Need at least 4 curve pieces to generate a circuit');
  }
  return Array(4).fill({ id: 'curve' });
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
