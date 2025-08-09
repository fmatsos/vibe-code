const express = require('express');
const path = require('node:path');
const { readCollection, writeCollection } = require('./db');

const app = express();
app.use(express.json());

const publicDir = path.join(__dirname, '..', 'public');
app.use(express.static(publicDir));

app.get('/api/collection', async (req, res) => {
  const collection = await readCollection();
  res.json(collection);
});

app.post('/api/collection', async (req, res) => {
  const body = req.body || {};
  await writeCollection(body);
  res.json(await readCollection());
});

if (require.main === module) {
  const port = process.env.PORT || 3000;
  app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
  });
}

module.exports = app;
