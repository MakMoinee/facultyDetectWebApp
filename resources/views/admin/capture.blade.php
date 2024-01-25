<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Capture</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
</head>

<body>
    <h1>Camera Capture</h1>
    <button id="startBtn">Start Capture</button>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startBtn = document.getElementById('startBtn');
            startBtn.addEventListener('click', startCapture);

            let stream; // Variable to store the camera stream

            async function startCapture() {
                // Prompt user for a name
                const folderName = prompt('Enter a name for the root folder:');
                if (!folderName) {
                    alert('Please enter a valid name.');
                    return;
                }

                try {
                    // Request camera permission
                    stream = await navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: {
                            width: 1280,
                            height: 720
                        },
                    });
                    handleSuccess(stream, folderName);
                } catch (error) {
                    console.error('Error accessing the camera:', error);

                    if (error.name === 'NotAllowedError') {
                        alert('Camera permission denied. Please grant permission to proceed.');
                    } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                        alert('No camera found. Please make sure a camera is connected and try again.');
                    } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                        alert(
                            'The camera is not readable. Please check if it is in use by another application.');
                    } else if (error.name === 'OverconstrainedError' || error.name ===
                        'ConstraintNotSatisfiedError') {
                        alert('Camera constraints are not satisfied. Please check your camera settings.');
                    } else {
                        alert('Error accessing the camera. Please try again.');
                    }
                }
            }

            function handleSuccess(stream, folderName) {
                const zip = new JSZip();
                const rootDirectory = zip.folder(folderName);

                const video = document.createElement('video');
                video.srcObject = stream;
                document.body.appendChild(video);

                // Create canvas for image capture
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                video.addEventListener('loadedmetadata', () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    // Capture and save images
                    captureImages(video, context, 100, rootDirectory, 'train');
                    captureImages(video, context, 100, rootDirectory, 'val');

                    // Generate and download zip file
                    zip.generateAsync({
                        type: 'blob'
                    }).then(blob => {
                        const zipFileName = `${folderName}.zip`;
                        saveAs(blob, zipFileName);
                    });
                });
            }

            function captureImages(video, context, count, rootDirectory, subfolder) {
                const folder = rootDirectory.folder(subfolder);

                for (let i = 0; i < count; i++) {
                    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

                    // Convert the canvas content to a data URL
                    const dataUrl = canvas.toDataURL('image/jpeg');

                    // Convert data URL to Blob
                    const byteString = atob(dataUrl.split(',')[1]);
                    const mimeString = dataUrl.split(',')[0].split(':')[1].split(';')[0];
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    const blob = new Blob([ab], {
                        type: mimeString
                    });

                    // Save image to zip file
                    folder.file(`image_${i + 1}.jpg`, blob);
                }
            }
        });
    </script>
</body>

</html>
