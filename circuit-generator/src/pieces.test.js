const pieces = require('./pieces');

test('contains at least one piece', () => {
  expect(pieces.length).toBeGreaterThan(0);
});

test('pieces have unique ids', () => {
  const ids = pieces.map(p => p.id);
  const uniqueIds = new Set(ids);
  expect(uniqueIds.size).toBe(ids.length);
});
