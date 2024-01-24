
const zona1 = document.getElementById("dz1");
const zona2 = document.getElementById("dz2");

zona1.addEventListener("change", function() {
  updateImageDisplay('preview1')
}, false);

function handleFiles1() {
  const span1 = document.getElementById("sp1");
  const fileList = this.files.length;
  let text = "Archivos seleccionados " + fileList;
  span1.textContent = text;
  span1.hidden = false;
}

zona2.addEventListener("change", function() {
  updateImageDisplay('preview2')
}, false);

const fileTypes = [
  "image/jpeg",
  "image/png"
];

function validFileType(file) {
  return fileTypes.includes(file.type);
}

function returnFileSize(number) {
  if (number < 1024) {
    return `${number} bytes`;
  } else if (number >= 1024 && number < 1048576) {
    return `${(number / 1024).toFixed(1)} KB`;
  } else if (number >= 1048576) {
    return `${(number / 1048576).toFixed(1)} MB`;
  }
}

function updateImageDisplay(idPreview) {
  let preview = document.getElementById(idPreview);
  console.log(preview);
  while (preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  let curFiles;
  if (idPreview == 'preview1') {
    curFiles = zona1.files;
  } else {
    curFiles = zona2.files;
  }

  console.log(curFiles);

  if (curFiles.length === 0) {
    let sinImg = document.createElement('img');
    sinImg.height = "350";
    sinImg.style.width = "100%";
    sinImg.src = "img/sinFoto.png";
    preview.appendChild(sinImg);
  } else {

    for (const file of curFiles) {
      const divImg = document.createElement('div');
      const para = document.createElement('p');
      if (validFileType(file)) {
        para.textContent = `Tamaño de archivo: ${returnFileSize(file.size)}.`;
        const image = document.createElement('img');
        image.height = "550";
        image.style.width = "100%";
        image.src = URL.createObjectURL(file);

        divImg.appendChild(image);
        divImg.appendChild(para);
      } else {
        para.textContent = `Archivo: ${file.name}: Tipo no valido, selecciona otra foto..`;
        divImg.appendChild(para);
      }
      preview.appendChild(divImg);
    }
  }
}