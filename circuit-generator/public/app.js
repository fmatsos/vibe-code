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
  console.log(data);
}

document.getElementById('save-collection').addEventListener('click', async (e) => {
  e.preventDefault();
  await saveCollection();
});

document.getElementById('generate-btn').addEventListener('click', async (e) => {
  e.preventDefault();
  await generateCircuit();
});

fetchCollection();
