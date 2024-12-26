//image upload
document.addEventListener('DOMContentLoaded', function() {
    const mediaInput = document.getElementById('media');
    const uploadButton = document.getElementById('uploadButton');
    const previewContainer = document.getElementById('previewContainer');

    uploadButton.addEventListener('click', function() {
        mediaInput.click();
    });

    mediaInput.addEventListener('change', function(event) {
        const files = event.target.files;
        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-16', 'h-16', 'object-cover', 'rounded-md');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
});

//fabric things

//init canvas
const canvasElement = document.getElementById('fabricCanvas');
canvasElement.width = canvasElement.clientWidth;
canvasElement.height = 500;

const canvas = new fabric.Canvas('fabricCanvas');

// TEXT FUNCTIONS
function addTextToCanvas() {
    const text = new fabric.IText('Your Text Here', {
        left: 100,
        top: 100,
        fontSize: 20,
        fill: 'black',
        fontFamily: 'Inter',
        fontWeight: 'normal',
        fontStyle: 'normal',
        underline: false,
        textAlign: 'left',
        splitByGrapheme: true,
        width: 500,
    });

    // dynamic adjust width
    text.on('changed', function () {
        const width = text.width;
        const height = text.height;

        text.set({
            width: width,
            height: height
        });

        text.setCoords();
        canvas.renderAll();
    });

    canvas.add(text);
    console.log('added text');
}

const canvasTextElement = document.getElementById('canvasText');
canvasTextElement.addEventListener('click', addTextToCanvas);

// EDIT TEXT
canvas.on('object:selected', function (e) {
    const selectedObject = e.target;
    if (selectedObject && selectedObject.type === 'i-text') {
        // Enable editing
        selectedObject.enterEditing();
        selectedObject.selectAll();
    }
});

canvas.on('text:editing:exited', function (e) {
    const editedText = e.target.text;
    console.log('Edited text:', editedText);

    e.target.setCoords();
    canvas.renderAll();
});

// DELETE FUNCTION
document.addEventListener('DOMContentLoaded', function () {
    function deleteSelectedObjects() {
        const activeObjects = canvas.getActiveObjects();
        if (activeObjects.length) {
            activeObjects.forEach((object) => {
                canvas.remove(object);
            });
            canvas.discardActiveObject();
            canvas.renderAll();
            console.log('Objects deleted:', activeObjects.length);
        } else {
            console.log('No objects selected to delete');
        }
    }

    const deleteButton = document.getElementById('deleteObject');
    if (deleteButton) {
        deleteButton.addEventListener('click', deleteSelectedObjects);
    } else {
        console.error("Element with ID 'deleteObject' not found in the DOM.");
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Delete') {
            deleteSelectedObjects();
        }
    });
});


// IMAGE FUNCTIONS
document.getElementById('canvasImg').addEventListener('click', function () {
    document.getElementById('canvasImgUpload').click();
});

document.getElementById('canvasImgUpload').addEventListener('change', function (e) {
    const input = e.target;
    const reader = new FileReader();

    reader.onload = function() {
        const imgElement = document.createElement('img');
        imgElement.src = reader.result;

        imgElement.onload = function() {
            const imgInstance = new fabric.Image(imgElement, {
                angle: 0,
                opacity: 1,
                cornerSize: 30,
            });

            const canvasWidth = canvas.getWidth();
            const canvasHeight = canvas.getHeight();

            if (imgElement.width > imgElement.height) {
                imgInstance.scaleToWidth(canvasWidth - 50);
            } else {
                imgInstance.scaleToHeight(canvasHeight - 50);
            }

            canvas.add(imgInstance);

            canvas.centerObject(imgInstance);
        };
    };

    reader.readAsDataURL(input.files[0]);
});

document.getElementById('canvasImgUpload').value = '';
