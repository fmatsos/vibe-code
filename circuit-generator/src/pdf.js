const { PDFDocument, StandardFonts } = require('pdf-lib');

async function generatePdf(circuit, hash) {
  const pdfDoc = await PDFDocument.create();
  const page = pdfDoc.addPage();
  const { height } = page.getSize();
  const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
  page.drawText('Circuit: ' + circuit.map(p => p.id).join(', '), {
    x: 50,
    y: height - 50,
    size: 12,
    font,
  });
  page.drawText('Hash: ' + hash, {
    x: 50,
    y: height - 70,
    size: 12,
    font,
  });
  return await pdfDoc.save();
}

module.exports = { generatePdf };
