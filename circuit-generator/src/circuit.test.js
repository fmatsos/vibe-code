const { generateCircuit } = require('./circuit');

describe('generateCircuit', () => {
  test('returns four curves when only curves available', () => {
    const circuit = generateCircuit({ curve: 4 }, 4);
    expect(circuit).toHaveLength(4);
    expect(circuit.every(p => p.id === 'curve')).toBe(true);
  });

  test('uses straight pieces when available to extend circuit', () => {
    const circuit = generateCircuit({ curve: 4, 'straight-short': 2 }, 6);
    expect(circuit).toHaveLength(6);
    const curveCount = circuit.filter(p => p.id === 'curve').length;
    expect(curveCount).toBe(4);
  });

  test('throws error when circuit cannot be generated', () => {
    expect(() => generateCircuit({ curve: 4 }, 3)).toThrow(/Need at least 4 curve pieces/);
    expect(() => generateCircuit({ curve: 3 }, 4)).toThrow(/Need at least 4 curve pieces/);
  });
});

