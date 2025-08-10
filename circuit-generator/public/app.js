const pieces = [
  { id: 'straight-short', name: 'Ligne courte' },
  { id: 'straight-long', name: 'Ligne longue' },
  { id: 'curve', name: 'Courbe' },
  { id: 'switch-left', name: 'Aiguillage gauche' },
  { id: 'switch-right', name: 'Aiguillage droite' },
];

async function fetchCollection() {
  const res = await fetch('/api/collection');
  const collection = await res.json();
  const form = document.getElementById('collection-form');
  form.innerHTML = '';

  pieces.forEach((piece) => {
    const wrapper = document.createElement('label');
    wrapper.className = 'flex items-center gap-2';

    const span = document.createElement('span');
    span.textContent = piece.name;
    span.className = 'w-40';

    const input = document.createElement('input');
    input.type = 'number';
    input.min = '0';
    input.value = collection[piece.id] || 0;
    input.dataset.pieceId = piece.id;
    input.className = 'input input-bordered w-24';

    wrapper.appendChild(span);
    wrapper.appendChild(input);
    form.appendChild(wrapper);
  });
}

async function saveCollection() {
  const inputs = document.querySelectorAll('[data-piece-id]');
  const payload = {};
  inputs.forEach((input) => {
    const value = parseInt(input.value, 10) || 0;
    if (value > 0) {
      payload[input.dataset.pieceId] = value;
    }
  });
  await fetch('/api/collection', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload),
  });
}

async function generateCircuit() {
  const count = parseInt(document.getElementById('pieces-count').value, 10) || 0;
  const res = await fetch('/api/generate', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ maxPieces: count }),
  });
  const data = await res.json();
  document.getElementById('hash-input').value = data.hash || '';
  if (data.circuit) {
    renderCircuit(data.circuit);
  }
}

async function retrieveCircuit() {
  const hash = document.getElementById('hash-input').value.trim();
  if (!hash) return;
  const res = await fetch(`/api/retrieve/${hash}`);
  const data = await res.json();
  if (data.circuit) {
    renderCircuit(data.circuit);
  }
}

function renderCircuit(circuit) {
  const svg = document.getElementById('circuit-svg');
  svg.innerHTML = '';
  let x = 50;
  let y = 50;
  let dir = 0; // 0:right,1:down,2:left,3:up
  const step = 50;
  let d = `M ${x} ${y}`;
  circuit.forEach((piece) => {
    if (piece.id === 'curve') {
      if (dir === 0) { x += step; y += step; }
      else if (dir === 1) { x -= step; y += step; }
      else if (dir === 2) { x -= step; y -= step; }
      else { x += step; y -= step; }
      dir = (dir + 1) % 4;
    } else {
      if (dir === 0) x += step;
      else if (dir === 1) y += step;
      else if (dir === 2) x -= step;
      else y -= step;
    }
    d += ` L ${x} ${y}`;
  });
  d += ' Z';
  const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  path.setAttribute('d', d);
  path.setAttribute('stroke', 'black');
  path.setAttribute('fill', 'none');
  svg.appendChild(path);
}

document.getElementById('save-collection').addEventListener('click', async (e) => {
  e.preventDefault();
  await saveCollection();
});

document.getElementById('generate-btn').addEventListener('click', async (e) => {
  e.preventDefault();
  await generateCircuit();
});

document.getElementById('retrieve-btn').addEventListener('click', async (e) => {
  e.preventDefault();
  await retrieveCircuit();
});

fetchCollection();
