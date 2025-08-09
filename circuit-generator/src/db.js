const fs = require('node:fs/promises');
const path = require('node:path');

const DB_PATH = process.env.DB_PATH || path.join(__dirname, '..', 'database.json');

async function readCollection() {
  try {
    const data = await fs.readFile(DB_PATH, 'utf8');
    const json = JSON.parse(data);
    return json.collection || {};
  } catch (err) {
    if (err.code === 'ENOENT') {
      return {};
    }
    throw err;
  }
}

async function writeCollection(collection) {
  const data = { collection };
  await fs.writeFile(DB_PATH, JSON.stringify(data, null, 2));
}

module.exports = {
  readCollection,
  writeCollection,
};
