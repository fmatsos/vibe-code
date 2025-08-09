const http = require('node:http');
const fs = require('node:fs/promises');
const path = require('node:path');

let server;
let baseUrl;

beforeEach(async () => {
  process.env.DB_PATH = path.join(__dirname, 'database.test.json');
  await fs.writeFile(process.env.DB_PATH, JSON.stringify({ collection: {} }));
  const app = require('./server');
  server = http.createServer(app);
  await new Promise((resolve) => server.listen(0, resolve));
  const { port } = server.address();
  baseUrl = `http://localhost:${port}`;
});

afterEach(async () => {
  await new Promise((resolve) => server.close(resolve));
  await fs.unlink(process.env.DB_PATH);
  delete process.env.DB_PATH;
  delete require.cache[require.resolve('./server')];
});

test('GET /api/collection returns stored collection', async () => {
  const res = await fetch(`${baseUrl}/api/collection`);
  const data = await res.json();
  expect(res.status).toBe(200);
  expect(data).toEqual({});
});

test('POST /api/collection stores collection', async () => {
  const resPost = await fetch(`${baseUrl}/api/collection`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ curve: 2 }),
  });
  expect(resPost.status).toBe(200);
  const resGet = await fetch(`${baseUrl}/api/collection`);
  const data = await resGet.json();
  expect(data).toEqual({ curve: 2 });
});

test('POST /api/generate returns not implemented', async () => {
  const res = await fetch(`${baseUrl}/api/generate`, { method: 'POST' });
  expect(res.status).toBe(501);
});

test('GET /api/retrieve/:hash returns not implemented', async () => {
  const res = await fetch(`${baseUrl}/api/retrieve/foo`);
  expect(res.status).toBe(501);
});

test('POST /api/export/pdf returns not implemented', async () => {
  const res = await fetch(`${baseUrl}/api/export/pdf`, { method: 'POST' });
  expect(res.status).toBe(501);
});
