const express = require('express');
const path = require('node:path');
const { readCollection, writeCollection } = require('./db');
const {
  generateCircuit,
  serializeCircuit,
  deserializeCircuit,
} = require('./circuit');
const { generatePdf } = require('./pdf');

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

app.post('/api/generate', async (req, res) => {
  try {
    const collection = await readCollection();
    const { maxPieces } = req.body || {};
    const circuit = generateCircuit(collection, maxPieces);
    const hash = serializeCircuit(circuit);
    res.json({ circuit, hash });
  } catch (err) {
    res.status(400).json({ error: err.message });
  }
});

app.get('/api/retrieve/:hash', (req, res) => {
  try {
    const circuit = deserializeCircuit(req.params.hash);
    res.json({ circuit });
  } catch {
    res.status(400).json({ error: 'Invalid hash' });
  }
});

app.post('/api/export/pdf', async (req, res) => {
  try {
    let { circuit, hash } = req.body || {};
    if (!circuit && hash) {
      circuit = deserializeCircuit(hash);
    }
    if (!circuit) {
      return res.status(400).json({ error: 'Missing circuit or hash' });
    }
    if (!hash) {
      hash = serializeCircuit(circuit);
    }
    const pdfBytes = await generatePdf(circuit, hash);
    res.setHeader('Content-Type', 'application/pdf');
    res.send(Buffer.from(pdfBytes));
  } catch (err) {
    res.status(500).json({ error: 'PDF generation failed' });
  }
});

if (require.main === module) {
  const port = process.env.PORT || 3000;
  app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
  });
}

module.exports = app;
