var dbJson = null;
var temp_id = null;
var image = null;
var base_url = $("#base_url").text();
var canvas;
var shapeImageUrl;
let currentImage = null;
let isImageDragging = false; // Track if the image is being dragged
let isimageoncanvas = false;
let oldImage = null;
var current_shape;
$(document).on("click", ".design-card", function() {
    var url = $(this).data("url");
    var template = $(this).data("template");
    var imageUrl = $(this).data("image");
    shapeImageUrl = $(this).data('shape_image');
    var json = $(this).data("json");
    //console.log(json);
    var id = $(this).data("id");
    $(".edit_design_tem").attr("data-image", imageUrl);
    if (eventData.textData != null && eventData.temp_id != null && eventData.temp_id == id) {
        dbJson = eventData.textData;
    } else {
        //console.log(json);
        dbJson = json;
        temp_id = id;
    }

    // Set the image URL in the modal's image tag
    $("#modalImage").attr("src", imageUrl);
    image = imageUrl;

    // Remove the old canvas if it exists
    $("#imageEditor2").remove();

    // Create a new canvas element
    var newCanvas = $("<canvas>", {
        id: "imageEditor2",
        width: 345,
        height: 490,
    });

    // Append the new canvas to the modal-design-card
    $(".modal-design-card").html(newCanvas);

    // Show the modal
    $("#exampleModal").modal("show");

    canvas = new fabric.Canvas("imageEditor2", {
        width: 345,
        height: 490,
        position: "relative",
    });

    const defaultSettings = {
        fontSize: 20,
        letterSpacing: 0,
        lineHeight: 1.2,
    };

    fabric.Image.fromURL(image, function(img) {
        img.set({
            left: 0,
            top: 0,
            selectable: false,
            hasControls: false,
        });
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
    });

    const staticInfo = dbJson;

    staticInfo.textElements.forEach((element) => {
        //console.log(element);
        let textElement = new fabric.Textbox(element.text, {
            left: element.left,
            top: element.top,
            width: element.width || 200,
            fontSize: element.fontSize,
            fill: element.fill,
            fontFamily: element.fontFamily,
            fontWeight: element.fontWeight,
            fontStyle: element.fontStyle,
            underline: element.underline,
            linethrough: element.linethrough,
            backgroundColor: element.backgroundColor,
            textAlign: element.textAlign,
            editable: false,
            selectable: false,
            hasControls: false,
            borderColor: "#2DA9FC",
            cornerColor: "#fff",
            cornerSize: 10,
            transparentCorners: false,
            isStatic: true,
            angle: element?.rotation ? element?.rotation : 0
        });
        switch (element.text) {
            case "event_name":
                if (eventData.event_name) {
                    textElement.set({
                        text: eventData.event_name
                    });
                } else {
                    return; // Skip adding the element if event_name is empty
                }
                break;
            case "host_name":
                if (eventData.hosted_by) {
                    textElement.set({
                        text: eventData.hosted_by
                    });
                } else {
                    return; // Skip adding the element if host_name is empty
                }
                break;
            case "Location":
                if (eventData.event_location) {
                    textElement.set({
                        text: eventData.event_location
                    });
                } else {
                    return; // Skip adding the element if event_location_name is empty
                }
                break;
            case "start_time":
                if (eventData.start_time) {
                    textElement.set({
                        text: eventData.start_time
                    });
                } else {
                    return; // Skip adding the element if start_time is empty
                }
                break;
            case "rsvp_end_time":
                if (eventData.rsvp_end_time) {
                    textElement.set({
                        text: eventData.rsvp_end_time
                    });
                } else {
                    return; // Skip adding the element if rsvp_end_time is empty
                }
                break;
            case "start_date":
                if (eventData.event_date) {
                    var start_date = "";
                    if (eventData.event_date.includes(" To ")) {
                        let [start, end] = eventData.event_date.split(" To ");
                        start_date = start;
                    } else {
                        start_date = eventData.event_date;
                    }

                    textElement.set({
                        text: start_date
                    });
                } else {
                    return; // Skip adding the element if start_date is empty
                }
                break;
            case "end_date":
                if (eventData.event_date) {
                    var end_date = "";
                    if (eventData.event_date.includes(" To ")) {
                        let [start, end] = eventData.event_date.split(" To ");
                        end_date = end;
                    } else {
                        end_date = eventData.event_date;
                    }

                    textElement.set({
                        text: end_date
                    });
                } else {
                    return; // Skip adding the element if end_date is empty
                }
                break;
        }
        const textWidth = textElement.calcTextWidth();
        textElement.set({
            width: textWidth
        });
        canvas.add(textElement);
    });
    var shape = '';
    if (dbJson) {
       
    }

    // Load filed image (filedImagePath) as another image layer
    if (shapeImageUrl) {
        let element = staticInfo?.shapeImageData;
        if (element.shape && element.centerX && element.centerY && element.height && element.width) {
            
            const imageInput = document.getElementById('image1');
            const scaledWidth = element.width;  // Use element's width
            const scaledHeight = element.height;

            imageInput.style.width = element.width + 'px';
            imageInput.style.height = element.height + 'px';
            
            let currentImage = null; // Variable to hold the current image
            let isScaling = false; // Flag to check if the image is scaling
            let currentShapeIndex = 0; // Index to track the current shape

            // Define default shape variable (can be changed as needed)
            const defaultShape = element.shape; // Set the desired default shape here

            // Create a mapping of shape names to their indices
            const shapeIndexMap = {
                'rectangle': 0,
                'circle': 1,
                'triangle': 2,
                'star': 3
            };

            function createShapes(img) {
                const imgWidth = img.width;
                const imgHeight = img.height;
                const starScale = Math.min(imgWidth, imgHeight) / 2; // Adjust the star size based on the image

                // Proper 5-point star shape
                const starPoints = [
                    { x: 0, y: -starScale }, // Top point
                    { x: starScale * 0.23, y: -starScale * 0.31 }, // Top-right
                    { x: starScale, y: -starScale * 0.31 }, // Right
                    { x: starScale * 0.38, y: starScale * 0.12 }, // Bottom-right
                    { x: starScale * 0.58, y: starScale }, // Bottom
                    { x: 0, y: starScale * 0.5 }, // Center-bottom
                    { x: -starScale * 0.58, y: starScale }, // Bottom-left
                    { x: -starScale * 0.38, y: starScale * 0.12 }, // Top-left
                    { x: -starScale, y: -starScale * 0.31 }, // Left
                    { x: -starScale * 0.23, y: -starScale * 0.31 } // Top-left
                ];

                return [
                    new fabric.Rect({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Circle({ radius: Math.min(imgWidth, imgHeight) / 2, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Triangle({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Polygon(starPoints, { originX: 'center', originY: 'center', angle: 0 })
                ];
            }

            // Load the initial image
            fabric.Image.fromURL(shapeImageUrl, function (img) {
                img.set({

                    selectable: false,
                    hasControls: false,
                    hasBorders: false,
                    borderColor: "#2DA9FC",
                    cornerColor: "#fff",
                    transparentCorners: false,
                    lockUniScaling: true,
                    scaleX: scaledWidth / img.width,  // Scale based on element's width
                    scaleY: scaledHeight / img.height, // Scale based on element's height
                    cornerSize: 10,
                    cornerStyle: 'circle',
                    left: element.centerX - scaledWidth / 2, // Center the image horizontally
                    top: element.centerY - scaledHeight / 2  
                });

                let shapes = createShapes(img);

                currentShapeIndex = shapeIndexMap[defaultShape] || 0; // Default to rectangle if not found

                img.set({ clipPath: shapes[currentShapeIndex] });
                img.crossOrigin = "anonymous";

                img.on('mouseup', function(event) {
                    console.log(event);
                    if(event?.transform?.action === 'drag' && event.transform.actionPerformed === undefined){
                        currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
                        img.set({ clipPath: shapes[currentShapeIndex] });
                        canvas.renderAll();
                    }
                });

                const fixClipPath = () => {
                    img.set({ clipPath: shapes[currentShapeIndex] });
                    canvas.renderAll();
                };

                img.on('scaling', function (event) {
                    const target = event.target;
                    if (target && target.isControl) {
                        fixClipPath();
                    }
                });

                canvas.add(img);
                currentImage = img; // Store the image reference
                $("#shape_img").attr("src",shapeImageUrl);
                $("#first_shape_img").attr("src",shapeImageUrl);

                // Custom control for the upload button (centered)
                fabric.Object.prototype.controls.uploadControl = new fabric.Control({
                    x: 0,
                    y: 0,
                    offsetX: 0,
                    offsetY: 0,
                    cursorStyle: 'pointer',
                    mouseUpHandler: function () {
                        imageInput.click();
                    },
                    render: function (ctx, left, top, styleOverride, fabricObject) {
                        const imgIcon = document.createElement('img');

                        const svgString = `
                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.625" width="30" height="30" rx="15" fill="white"/>
                        <path d="M22 17.2502V21.5834C22 21.727 21.9429 21.8648 21.8414 21.9664C21.7398 22.0679 21.602 22.125 21.4583 22.125H9.54167C9.39801 22.125 9.26023 22.0679 9.15865 21.9664C9.05707 21.8648 9 21.727 9 21.5834V17.2502C9 17.1065 9.05707 16.9687 9.15865 16.8672C9.26023 16.7656 9.39801 16.7085 9.54167 16.7085C9.68533 16.7085 9.8231 16.7656 9.92468 16.8672C10.0263 16.9687 10.0833 17.1065 10.0833 17.2502V21.0417H20.9167V17.2502C20.9167 17.1065 20.9737 16.9687 21.0753 16.8672C21.1769 16.7656 21.3147 16.7085 21.4583 16.7085C21.602 16.7085 21.7398 16.7656 21.8414 16.8672C21.9429 16.9687 22 17.1065 22 17.2502ZM12.7917 12.917H14.9583V17.2502C14.9583 17.3938 15.0154 17.5316 15.117 17.6332C15.2186 17.7347 15.3563 17.7918 15.5 17.7918C15.6437 17.7918 15.7814 17.7347 15.883 17.6332C15.9846 17.5316 16.0417 17.3938 16.0417 17.2502V12.917H18.2083C18.3155 12.9171 18.4203 12.8853 18.5095 12.8258C18.5986 12.7663 18.6681 12.6817 18.7092 12.5827C18.7502 12.4836 18.7609 12.3747 18.74 12.2695C18.7191 12.1644 18.6674 12.0679 18.5916 11.9921L15.8832 9.28386C15.8329 9.2335 15.7732 9.19355 15.7074 9.16629C15.6417 9.13903 15.5712 9.125 15.5 9.125C15.4288 9.125 15.3583 9.13903 15.2926 9.16629C15.2268 9.19355 15.1671 9.2335 15.1168 9.28386L12.4084 11.9921C12.3326 12.0679 12.2809 12.1644 12.26 12.2695C12.2391 12.3747 12.2498 12.4836 12.2908 12.5827C12.3319 12.6817 12.4014 12.7663 12.4905 12.8258C12.5797 12.8853 12.6845 12.9171 12.7917 12.917Z" fill="black"/>
                        </svg>`;
                        const encodedSvg = encodeURIComponent(svgString);
                        const imgSrc = `data:image/svg+xml;charset=utf-8,${encodedSvg}`;
                        imgIcon.src = imgSrc;
                        imgIcon.crossOrigin = "anonymous";
                        imgIcon.width = 24;
                        imgIcon.height = 24;

                        ctx.drawImage(imgIcon, left - 12, top - 12, 24, 24);
                    }
                });

                // Event listener for image selection (file input)
                imageInput.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function () {

                            $("#shape_img").attr("src", reader.result);

                            fabric.Image.fromURL(reader.result, function (newImg) {
                                // Remove the old image if it exists
                                const newWidth = img.width;
                                const newHeight = img.height;
                                if (currentImage) {
                                    canvas.remove(currentImage);
                                }
            
                                newImg.set({
                                    selectable: false,
                                    hasControls: false,
                                    hasBorders: false,
                                    borderColor: "#2DA9FC",
                                    cornerColor: "#fff",
                                    transparentCorners: false,
                                    lockUniScaling: true,
                                    scaleX: scaledWidth / newWidth,  // Scale based on element's width
                                    scaleY: scaledHeight / newHeight, // Scale based on element's height
                                    cornerSize: 10,
                                    cornerStyle: 'circle',
                                    left: element.centerX - scaledWidth / 2, // Center the image horizontally
                                    top: element.centerY - scaledHeight / 2  
                                });

                                shapes = createShapes(newImg);
                                canvas.add(newImg);
                                currentImage = newImg; 
                                // $("#shape_img").attr("src",shapeImageUrl);
                                shapeImageUrl = $("#shape_img").attr("src");
                                // Reset shape index for the new image based on the default shape
                                currentShapeIndex = shapeIndexMap[defaultShape] || 0; // Default to rectangle if not found
                                newImg.set({ clipPath: shapes[currentShapeIndex] });
                                newImg.crossOrigin = "anonymous";

                                newImg.on('mouseup', function(event) {
                                    console.log(event);
                                    if(event?.transform?.action === 'drag' && event.transform.actionPerformed === undefined){
                                        currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
                                        newImg.set({ clipPath: shapes[currentShapeIndex] });
                                        canvas.renderAll();
                                    }
                                });

                                const fixClipPath = () => {
                                    newImg.set({ clipPath: shapes[currentShapeIndex] });
                                    canvas.renderAll();
                                };

                                newImg.on('scaling', function () {
                                    // isScaling = true; // Set scaling flag
                                    fixClipPath();
                                });
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
           
        }
    }

});
$(document).on("click", ".modal-design-card", function(e) {
    e.stopPropagation();
});

$(document).on("click", ".close-btn", function() {
    toggleSidebar();
    var id = $(this).data("id");
    $("#sidebar").removeClass(id);
});

$(document).on("click", ".design-sidebar-action", function() {
    let designId = $(this).attr("design-id");
    if (designId) {
        if (designId == "6") {
            var imgSrc1 = $(".photo-slider-1").attr("src");
            var imgSrc2 = $(".photo-slider-2").attr("src");
            var imgSrc3 = $(".photo-slider-3").attr("src");
            if (imgSrc1 != "" || imgSrc2 != "" || imgSrc3 != "") {
                $(".design-sidebar").addClass("d-none");
                $(".design-sidebar_7").removeClass("d-none");
                $("#sidebar").addClass("design-sidebar_7");
                $(".close-btn").attr("data-id", "design-sidebar_7");
            } else {
                $(".design-sidebar").addClass("d-none");
                $(".design-sidebar_" + designId).removeClass("d-none");
                $("#sidebar").addClass("design-sidebar_" + designId);
                $(".close-btn").attr("data-id", "design-sidebar_" + designId);
            }
        } else {
            $(".design-sidebar").addClass("d-none");
            $(".design-sidebar_" + designId).removeClass("d-none");
            $("#sidebar").addClass("design-sidebar_" + designId);
            $(".close-btn").attr("data-id", "design-sidebar_" + designId);
        }
    }
});

$(document).on("click", ".edit_design_tem", function(e) {
    e.preventDefault();
    // //console.log(dbJson);
    // //console.log(image);

    $("step_1").hide();
    $(".step_2").hide();
    $(".step_3").hide();
    $('.pick-card').removeClass('active');
    $('.pick-card').addClass('menu-success');
    $('.edit-design').removeClass('menu-success')
    $('.edit-design').addClass('active');
    $(".event_create_percent").text("50%");
    $(".current_step").text("2 of 4");
    $(".step_4").hide();
    $("#exampleModal").modal("hide");
    $(".edit_design_template").remove();

    $.ajax({
        url: base_url + "event/get_design_edit_page",
        method: "POST",
        dataType: 'html',
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function(response) {
            //console.log(response);
            $("#edit-design-temp").html(response).show();
            bindData();
        },
        error: function(xhr, status, error) {},
    });

});

function bindData() {

    let iw = document.getElementById('imageWrapper')
    // $(iw).on('mousedown', handleMouseDown);
   
    // document.addEventListener('mousemove', resize);
    // document.addEventListener('mouseup', handleMouseUp);
    
    // document.addEventListener('mousemove', handleMouseMove);

    function loadTextDataFromDatabase() {
        if (image) {
            // //console.log(image);

            // Load background image
            fabric.Image.fromURL(image, function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    selectable: false, // Non-draggable background image
                    hasControls: false, // Disable resizing controls
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });
           

            // Load static information (text elements)
            if (dbJson) {
                const staticInfo = dbJson;
                staticInfo.textElements.forEach((element) => {
                    const textMeasurement = new fabric.Text(element.text, {
                        fontSize: element.fontSize,
                        fontFamily: element.fontFamily,
                        fontWeight: element.fontWeight,
                        fontStyle: element.fontStyle,
                        underline: element.underline,
                        linethrough: element.linethrough,
                    });

                    const textWidth = textMeasurement.width;
                    
                    console.log(element.underline);
                    let textElement = new fabric.Textbox(element.text, {
                        // Use Textbox for editable text
                        left: element.left,
                        top: element.top,
                        width: element.width || textWidth, // Default width if not provided
                        fontSize: element.fontSize,
                        fill: element.fill,
                        fontFamily: element.fontFamily,
                        fontWeight: element.fontWeight,
                        fontStyle: element.fontStyle,
                        underline: element.underline,
                        linethrough: element.linethrough,
                        backgroundColor: element.backgroundColor,
                        textAlign: element.textAlign,
                        hasControls: true,
                        borderColor: "#2DA9FC",
                        cornerColor: "#fff",
                        cornerSize: 10,
                        cornerStyle: 'circle',
                        transparentCorners: false,
                        lockScalingFlip: true,
                        hasBorders: true,
                        centeredRotation: true,
                        angle: element?.rotation ? element?.rotation : 0
                    });

                    textElement.setControlsVisibility({
                        mt: false, // Hide middle top control
                        mb: false, // Hide middle bottom control
                        bl: true, // Hide bottom left control
                        br: true, // Hide bottom right control
                        tl: true, // Hide top left control
                        tr: true, // Hide top right control
                        ml: true,  // Show middle left control
                        mr: true   // Show middle right control
                    });

                    switch (element.text) {
                        case "event_name":
                            if (eventData.event_name) {
                                let textWidth = getWidth(
                                    element,
                                    eventData.event_name
                                );
                                textElement.set({
                                    text: eventData.event_name,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if event_name is empty
                            }
                            break;
                        case "host_name":
                            if (eventData.hosted_by) {
                                let textWidth = getWidth(
                                    element,
                                    eventData.hosted_by
                                );
                                textElement.set({
                                    text: eventData.hosted_by,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if host_name is empty
                            }
                            break;
                        case "Location":
                            if (eventData.event_location) {
                                let textWidth = getWidth(
                                    element,
                                    eventData.event_location
                                );
                                textElement.set({
                                    text: eventData.event_location,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if event_location_name is empty
                            }
                            break;
                        case "start_time":
                            if (eventData.start_time) {
                                let textWidth = getWidth(
                                    element,
                                    eventData.start_time
                                );
                                textElement.set({
                                    text: eventData.start_time,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if start_time is empty
                            }
                            break;
                        case "rsvp_end_time":
                            if (eventData.rsvp_end_time) {
                                let textWidth = getWidth(
                                    element,
                                    eventData.rsvp_end_time
                                );
                                textElement.set({
                                    text: eventData.rsvp_end_time,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if rsvp_end_time is empty
                            }
                            break;
                        case "start_date":
                            if (eventData.event_date) {
                                var start_date = "";
                                if (eventData.event_date.includes(" To ")) {
                                    let [start, end] =
                                    eventData.event_date.split(" To ");
                                    start_date = start;
                                } else {
                                    start_date = eventData.event_date;
                                }
                                let textWidth = getWidth(element, start_date);
                                textElement.set({
                                    text: start_date,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if start_date is empty
                            }
                            break;
                        case "end_date":
                            if (eventData.event_date) {
                                var end_date = "";
                                if (eventData.event_date.includes(" To ")) {
                                    let [start, end] =
                                    eventData.event_date.split(" To ");
                                    end_date = end;
                                } else {
                                    end_date = eventData.event_date;
                                }
                                let textWidth = getWidth(element, end_date);
                                textElement.set({
                                    text: end_date,
                                    width: textWidth,
                                });
                            } else {
                                return; // Skip adding the element if end_date is empty
                            }
                            break;
                    }

                    canvas.add(textElement);
                });

                var rotateIcon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAHqSURBVHgBtZW7S8NQFMZPxFXbzUGULIJPdHBwUAgWQamDj1msg0MXHQWXCiIdHFpQKupgrVR0sovgZBEfQx0UdHBLH9bVpv0DjueksRbb5Da2/uBrm4Z7vvvde5IrgQBEdNLXDGmQJJOcxq0c6YYUkyQpCX+BisukAOkTxcRJip36bLBaY/HfBIzkQgMf1odKkv/T4JsnrJaI/lSwsQSqmaiiUTktj6l0Fm2gcO0mw8ADxfY0RcsXYMw1D3cPCbCBrzxFXDQl78o6Otp6sbNrBEddc/p1jamcTYaPIprSQH83OFpbwL+5BqHgFnR2tMP0nAfSmQ/R0Bnhhvu3d3UxqfQ7hvYjpXvRswscGJ4QJQkKTXh5uLgZ7tlFvL1PWJU44uWSzXKmM1lwOFr0pTFdxr5uYTOwSRLqhPfKAs3ShBNoWoFm+mha4fLqmpqiByxI6p9o8SCGDiL65lZrV24IbmUBQ82G2zGUPzhleJcX9DTcrvybW5n36vQ8pt+PhncsU9BZ8ywZSfhlpsLPgVQBF947PIGX1zd9Gd1T4+CedIGAJTIJl67IaAMbi1phyWmw+IpuFHLVbFg8clWsHw9YUacRH9kK1AoW90i1YRBHq2NXkMqD5keBSgqKZi+BDYyZspKkHLVnrpZxX+O67qGyL3x/AAAAAElFTkSuQmCC";
                var img = document.createElement('img');
                img.src = rotateIcon;


                var deleteIcon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEkAAABJCAYAAABxcwvcAAAACXBIWXMAACE4AAAhOAFFljFgAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAX9SURBVHgB7ZxPiBtVHMe/Kz12N7kJFpfZk2Jduz3Ug1aILohlBRs9FCrYnAQF2e7NomhyEPdQWFewBT00Uix60N0FS0GoCbT10B5a3YrVS6Zb22uTtPfX329mXvZldiYzSea9ZJJ+4G2SmclM5ru/3+/93p95wGMimcCAEEJk6SVHxaKyj0rWe5/1HWorr7ep3OAyMTFhwxDGRPJEmaPyFpXDcAXpB5tKlcoGv5JodaQVEidHZYXKfaGXM3wtpAn6wQUqFWGeGl8bw4xwLacmBk9NDJtY9IMsMRjLiaJGxcKgoR+xKPTHnH75HIOALpylsibSw3XRg1X1nAJ4F6ug/6rcNDaVPKUMN+J+4Qn0AAnE+c51pE8gxqJSoXs4FvcLXVuSJxBbUBbpp0AW9X3UQV2JNGICSSKFii1SimNQFNycebVTjIol0ggLJGGh9oc1muMGbs4xLIwuHD7WwnZGikRWtEgvBYw+c3SvK0E7Orqb52Y1jBccn6rqhihLWsH4cca/IVQk4bagD2P84Ib6cXVDqLvRgexmFgxx+Y9r2LpzN3Df9NN7cPClAzAI13YzsrdzV9ARnhVZMMDWnXt48+1CqEASFuqH8teY3fssDMC1HVtTkT8EWpJJK3rhwOuRAklYqEsXf0ZmahIGaFnTDksSbj+xBQNs/v1vSyC+8YVD84HHnb/wOxrNpnPs5s1bplyPrYljcjnI3WK3jvtFtSC+8VOrXwQed2JqGae/O+u837z5j8n4xFoEimSsRrt85Wrr/fT0HrKsW2g0HjifM5lJsq4pdx+5mYStzyDcX59ti0m0gQVaQ0I0mg9w7sd1bP1/17l5thxpPRywe4XFy2R2t8TjV1fUSRw9kqfPTyFBlvwicSJVQEK8Mv+OYx0mYcH+uvYbEqTqd7ccDML/ebYAiepWbHkcrFXiWZ9Awsy1LEm4w9D3kSDsWud+WvfcY9IRYdtFencJdmPpvvI6UtSFN+Yx+3yyuZQqUg5un9FjfKhttzlohF3l3cJHWD75DZLi9LdnnWzdWNwjS/pKaOTjT78UmSefc8qlK1dFv9Trzdb5FvLHhE5US9oHjXAckcRthnTCZK3Z07jbuKGKZEEjam2WhCWp59Dd4N0FQ8gmBqO6HsMBOMp9Zvc+gw/efy/43Jkp6MScSErSKNtn8v2Jz5ZjnePgyy+2+pNUS0q4GbKDoYhJcW7Syc7N9CPtQLUkrRMz1SZHWzwhC/v1l7LTum80mqHf574mVSS1iaKeWweqSDY0JpRq3PCLoTZX4qLGNd0WprpbAxrJTO3evlDzIfpFFdpk4OYJA9p6JdtqtwC34m5Z2fvoZ+HQa07DdVD43U0bbbWbLwVgPlz8JDQNOH/hIm7/1y7SoGq32NPjeqVTrqSKuON7AfsajYfKfkPuxtNOuN0IjRO0uMtVdqSxy6kBl2s4HqAMIqh/SO2QM51x83MamuOSW3UHuVzcURA1GTVA1Z9MVqGRsKy7W1Qr0p0jERt+kdahMakMSyi7RU0h1NRCE+ttInkTBLQF8PaMuXeReICydU69Qdt5ri6ogVuCplETblrIXGj55CmnadFt9e2O5W20Ph89onUsdZX/GJ8wkeRYHAvMtaKmuGTDnWxaD+sFiJwA3is8fSaJsXzNAjGtpzHDLIlzJbYmbTkTN0M4L/IPQEbBaQTnTQYmTczIKcudZroVEDB/cEwokUBF+SFq9i0PVuYwXtjwYpHcENUzWcL4UfI/Gd5RJG8+8yrGhzLdc9m/Me6zJfxsm9Zh8CHAhjvR3fbviDsQkIfm/qYBI59UsoN2xhLJ+3IemgcLBshSp2U9Yg8pec+DLWH0KAXFob4Q7soRo0IRuhCjIVQRuqGL8PNhNZE+eJGHQjf32tfSQCJ9j53a6HJNAKavuQBcI1CZQToyc+7Z2N+tQIkihme1Gz81MWzrKtEPOi6GQyyOPUXhdvsMH8JdJoh/YE2YZ7jFCUKYW5GrIlwrTu/qF8K1rqQFqwjXaixoZJBLKObg9ixY6LyEYt0rtlf+xPYyikbako8ADsJE9Bg3pI8AAAAASUVORK5CYII=";
                var img1 = document.createElement('img');
                img1.src = deleteIcon;

                var copyIcon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADEAAAAxCAYAAABznEEcAAAACXBIWXMAABYlAAAWJQFJUiTwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAMnSURBVHgB3Zq/axRBFMe/J7bm0gmKZtMFNRhBG1HYgHaCv0rRnIVCGqOdKYIGCyMIiY2CTQ6s1QgGLQwXMaTQIqeXkFjtoVibu/wBz/dud8ze5k5uZ2bv9vzAy/7I7t58982PN/M2g4QgIoc3vYEpNtnKmUxmExbJwAJcYCnoENt5NpfNQX3hoxTZymwf2eZYVBmdggvvsk2z/SYzVthyaCdB4QtkH4/tHpKEf6CX/DefNB7bBdiGHzoUPLyd2PMKP2yEzOu9LtJeHJggb4M6j0e6QvjGMUoPHvld+Q4y/xDg8qaAdFHkMeVY9OSuRleS77pZpA/pXKajJxt6gi8UD7hIL8PskUV1sMMT5I+cLtLNbLh9NKpOyY6YdnDYbquDuuoUeCFWW6hUt1Ba3UBcTp08AUMkEu6XiDgqwoOvsiXm3y/gSu4WdBg8MoBPH17CkDssYma3Ogq6VAcxePb8hV+gwwPIZve0fF9p9XvNe6W1jdq9Bkjovy2CGYEmDx/cjVU9zl3KYWn5CyqVLRgi0XRfuGG76BDiEQMu1kSwGpmVOegQ4xNTOH3mMjQ5qjzhoMOoNqKBq0QMIQVothEnNZ4wQYnIootRInrRxSgRVhez2o0SUUEX8194QoUdRRhQWluPdb2FcCPMppEIiZckBhqfeAQdDh7YBwsUlYgy/CoVq5cavXENMiVZWv4c5zZke3owevMqi9gPC3z9u0fJrK22xODxs5Tde4i+ra6TBm44FH8Dw0hWYp849b1SrdbmJD9+/qpVLY25heQ6FsMi8vDn19oD3/y7BUw9foq4iIC3r/LQYFH+RKenM7wZgwEiotU2Im1DpqnSPrI9rc8MQ8gcuxwV4fDGQ3eQZwHXZaduySZIOz1BdzCpdhqtO91H+kfwyXCer9kypmRpXiOdSI/UHz7RcEGZL5pDOquV1JDhWHdQBwfAJsTP45GfaFyhdJCDLpQOITnYgB80Q+3HI39NzB7yRqh9aeACNcnR2RDisOUpOTzyF7eTJwExBWr39x0RMbmgEHET9h75bc2FAVY+FQpD23kOsb7Iv2VVpRxY0dYnQn8AxkwzSD/FREQAAAAASUVORK5CYII=";
                var img2 = document.createElement('img');
                img2.src = copyIcon;
            
                
                fabric.Textbox.prototype.controls.mtr = new fabric.Control({
                    x: 0,
                    y: 0.5,
                    offsetY: 20,
                    cursorStyle: 'pointer',
                    actionHandler: fabric.controlsUtils.rotationWithSnapping,
                    actionName: 'rotate',
                    render: renderIcon,
                    cornerSize: 28,
                });
                
                fabric.Textbox.prototype.controls.deleteControl = new fabric.Control({
                    x: 0.3,
                    y: -0.5,
                    offsetY: -20,
                    cursorStyle: 'pointer',            
                    actionHandler: (eventData, transform, x, y) => {
                        console.log(eventData)
                        const target = transform.target;
                        canvas.remove(target); // Remove object on trash icon click
                        canvas.requestRenderAll();
                    },
                    mouseUpHandler: deleteTextbox,
                    render: renderDeleteIcon,
                    cornerSize: 28,
                    withConnection: false // Disable the line connection
                });


                fabric.Textbox.prototype.controls.copyControl = new fabric.Control({
                    x: -0.3,
                    y: -0.5,
                    offsetY: -20,
                    cursorStyle: 'pointer', 
                    mouseUpHandler: cloneTextbox,
                    render: renderCopyIcon,
                    cornerSize: 28,
                    withConnection: false // Disable the line connection
                });
                
                
                    // here's where the render action for the control is defined
                function renderIcon(ctx, left, top, styleOverride, fabricObject) {
                    var size = this.cornerSize;
                    ctx.save();
                    ctx.translate(left, top);
                    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
                    ctx.drawImage(img, -size / 2, -size / 2, size, size);
                    ctx.restore();
                }

                function renderDeleteIcon(ctx, left, top, styleOverride, fabricObject) {
                    var size = this.cornerSize;
                    ctx.save();
                    ctx.translate(left, top);
                    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
                    ctx.drawImage(img1, -size / 2, -size / 2, size, size);
                    ctx.restore();
                }
                function renderCopyIcon(ctx, left, top, styleOverride, fabricObject) {
                    var size = this.cornerSize;
                    ctx.save();
                    ctx.translate(left, top);
                    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
                    ctx.drawImage(img2, -size / 2, -size / 2, size, size);
                    ctx.restore();
                }



                let currentImage = null;
                let isImageDragging = false; // Track if the image is being dragged
                let isimageoncanvas = false;
                let oldImage = null;
                
                if (shapeImageUrl) {
                    let element = staticInfo?.shapeImageData;
                    if (element.shape && element.centerX && element.centerY && element.height && element.width) {
                        
                        const imageInput = document.getElementById('image');
                        const scaledWidth = element.width;  // Use element's width
                        const scaledHeight = element.height;

                        imageInput.style.width = element.width + 'px';
                        imageInput.style.height = element.height + 'px';
                        
                        let currentImage = null; // Variable to hold the current image
                        let isScaling = false; // Flag to check if the image is scaling
                        let currentShapeIndex = 0; // Index to track the current shape
            
                        // Define default shape variable (can be changed as needed)
                        const defaultShape = element.shape; // Set the desired default shape here
            
                        // Create a mapping of shape names to their indices
                        const shapeIndexMap = {
                            'rectangle': 0,
                            'circle': 1,
                            'triangle': 2,
                            'star': 3
                        };
            
                        function createShapes(img) {
                            const imgWidth = img.width;
                            const imgHeight = img.height;
                            const starScale = Math.min(imgWidth, imgHeight) / 2; // Adjust the star size based on the image
            
                            // Proper 5-point star shape
                            const starPoints = [
                                { x: 0, y: -starScale }, // Top point
                                { x: starScale * 0.23, y: -starScale * 0.31 }, // Top-right
                                { x: starScale, y: -starScale * 0.31 }, // Right
                                { x: starScale * 0.38, y: starScale * 0.12 }, // Bottom-right
                                { x: starScale * 0.58, y: starScale }, // Bottom
                                { x: 0, y: starScale * 0.5 }, // Center-bottom
                                { x: -starScale * 0.58, y: starScale }, // Bottom-left
                                { x: -starScale * 0.38, y: starScale * 0.12 }, // Top-left
                                { x: -starScale, y: -starScale * 0.31 }, // Left
                                { x: -starScale * 0.23, y: -starScale * 0.31 } // Top-left
                            ];
            
                            return [
                                new fabric.Rect({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                                new fabric.Circle({ radius: Math.min(imgWidth, imgHeight) / 2, originX: 'center', originY: 'center', angle: 0 }),
                                new fabric.Triangle({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                                new fabric.Polygon(starPoints, { originX: 'center', originY: 'center', angle: 0 })
                            ];
                        }
            
                        // Load the initial image
                        fabric.Image.fromURL(shapeImageUrl, function (img) {
                            img.set({

                                selectable: true,
                                hasControls: true,
                                hasBorders: true,
                                borderColor: "#2DA9FC",
                                cornerColor: "#fff",
                                transparentCorners: false,
                                lockUniScaling: true,
                                scaleX: scaledWidth / img.width,  // Scale based on element's width
                                scaleY: scaledHeight / img.height, // Scale based on element's height
                                cornerSize: 10,
                                cornerStyle: 'circle',
                                left: element.centerX - scaledWidth / 2, // Center the image horizontally
                                top: element.centerY - scaledHeight / 2  
                            });
            
                            let shapes = createShapes(img);
            
                            currentShapeIndex = shapeIndexMap[defaultShape] || 0; // Default to rectangle if not found
            
                            img.set({ clipPath: shapes[currentShapeIndex] });
                            img.crossOrigin = "anonymous";

                            img.on('mouseup', function(event) {
                                console.log(event);
                                if(event?.transform?.action === 'drag' && event.transform.actionPerformed === undefined){
                                    currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
                                    img.set({ clipPath: shapes[currentShapeIndex] });
                                    canvas.renderAll();
                                }
                            });
            
                            const fixClipPath = () => {
                                img.set({ clipPath: shapes[currentShapeIndex] });
                                canvas.renderAll();
                            };
            
                            img.on('scaling', function (event) {
                                const target = event.target;
                                if (target && target.isControl) {
                                    fixClipPath();
                                }
                            });
            
                            canvas.add(img);
                            currentImage = img; // Store the image reference
                            $("#shape_img").attr("src",shapeImageUrl);
                            $("#first_shape_img").attr("src",shapeImageUrl);

                            // Custom control for the upload button (centered)
                            fabric.Object.prototype.controls.uploadControl = new fabric.Control({
                                x: 0,
                                y: 0,
                                offsetX: 0,
                                offsetY: 0,
                                cursorStyle: 'pointer',
                                mouseUpHandler: function () {
                                    imageInput.click();
                                },
                                render: function (ctx, left, top, styleOverride, fabricObject) {
                                    const imgIcon = document.createElement('img');

                                    const svgString = `
                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.625" width="30" height="30" rx="15" fill="white"/>
                                    <path d="M22 17.2502V21.5834C22 21.727 21.9429 21.8648 21.8414 21.9664C21.7398 22.0679 21.602 22.125 21.4583 22.125H9.54167C9.39801 22.125 9.26023 22.0679 9.15865 21.9664C9.05707 21.8648 9 21.727 9 21.5834V17.2502C9 17.1065 9.05707 16.9687 9.15865 16.8672C9.26023 16.7656 9.39801 16.7085 9.54167 16.7085C9.68533 16.7085 9.8231 16.7656 9.92468 16.8672C10.0263 16.9687 10.0833 17.1065 10.0833 17.2502V21.0417H20.9167V17.2502C20.9167 17.1065 20.9737 16.9687 21.0753 16.8672C21.1769 16.7656 21.3147 16.7085 21.4583 16.7085C21.602 16.7085 21.7398 16.7656 21.8414 16.8672C21.9429 16.9687 22 17.1065 22 17.2502ZM12.7917 12.917H14.9583V17.2502C14.9583 17.3938 15.0154 17.5316 15.117 17.6332C15.2186 17.7347 15.3563 17.7918 15.5 17.7918C15.6437 17.7918 15.7814 17.7347 15.883 17.6332C15.9846 17.5316 16.0417 17.3938 16.0417 17.2502V12.917H18.2083C18.3155 12.9171 18.4203 12.8853 18.5095 12.8258C18.5986 12.7663 18.6681 12.6817 18.7092 12.5827C18.7502 12.4836 18.7609 12.3747 18.74 12.2695C18.7191 12.1644 18.6674 12.0679 18.5916 11.9921L15.8832 9.28386C15.8329 9.2335 15.7732 9.19355 15.7074 9.16629C15.6417 9.13903 15.5712 9.125 15.5 9.125C15.4288 9.125 15.3583 9.13903 15.2926 9.16629C15.2268 9.19355 15.1671 9.2335 15.1168 9.28386L12.4084 11.9921C12.3326 12.0679 12.2809 12.1644 12.26 12.2695C12.2391 12.3747 12.2498 12.4836 12.2908 12.5827C12.3319 12.6817 12.4014 12.7663 12.4905 12.8258C12.5797 12.8853 12.6845 12.9171 12.7917 12.917Z" fill="black"/>
                                    </svg>`;
                                    const encodedSvg = encodeURIComponent(svgString);
                                    const imgSrc = `data:image/svg+xml;charset=utf-8,${encodedSvg}`;
                                    imgIcon.src = imgSrc;
                                    imgIcon.crossOrigin = "anonymous";
                                    imgIcon.width = 24;
                                    imgIcon.height = 24;
            
                                    ctx.drawImage(imgIcon, left - 12, top - 12, 24, 24);
                                }
                            });
            
                            // Event listener for image selection (file input)
                            imageInput.addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function () {

                                        $("#shape_img").attr("src", reader.result);

                                        fabric.Image.fromURL(reader.result, function (newImg) {
                                            // Remove the old image if it exists
                                            const newWidth = img.width;
                                            const newHeight = img.height;
                                            let canvasState = canvas.toJSON();
    
                                            canvasState.objects = canvasState.objects.filter(function (obj) {
                                                // Check if the object is of type 'image'
                                                if (obj.type === 'image') {
                                                    // Find the corresponding Fabric.js image object on the canvas
                                                    const fabricImage = canvas.getObjects().find(image => image.toObject().src === obj.src);
                                                    // Remove the Fabric.js image from the canvas if found
                                                    if (fabricImage) {
                                                        canvas.remove(fabricImage);
                                                    }
                                                    return false; // Exclude this image object from the filtered array
                                                }
                                                return true; // Include other objects
                                            });
                                            
                                            // Render the updated canvas state
                                            canvas.renderAll();
                        
                                            newImg.set({
                                                selectable: true,
                                                hasControls: true,
                                                hasBorders: true,
                                                borderColor: "#2DA9FC",
                                                cornerColor: "#fff",
                                                transparentCorners: false,
                                                lockUniScaling: true,
                                                scaleX: scaledWidth / newWidth,  // Scale based on element's width
                                                scaleY: scaledHeight / newHeight, // Scale based on element's height
                                                cornerSize: 10,
                                                cornerStyle: 'circle',
                                                left: element.centerX - scaledWidth / 2, // Center the image horizontally
                                                top: element.centerY - scaledHeight / 2  
                                            });
            
                                            shapes = createShapes(newImg);
                                            canvas.add(newImg);
                                            currentImage = newImg; 
                                            // $("#shape_img").attr("src",shapeImageUrl);
                                            shapeImageUrl = $("#shape_img").attr("src");
                                            // Reset shape index for the new image based on the default shape
                                            currentShapeIndex = shapeIndexMap[defaultShape] || 0; // Default to rectangle if not found
                                            newImg.set({ clipPath: shapes[currentShapeIndex] });
                                            newImg.crossOrigin = "anonymous";

                                            newImg.on('mouseup', function(event) {
                                                console.log(event);
                                                if(event?.transform?.action === 'drag' && event.transform.actionPerformed === undefined){
                                                    currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
                                                    newImg.set({ clipPath: shapes[currentShapeIndex] });
                                                    canvas.renderAll();
                                                }
                                            });
            
                                            const fixClipPath = () => {
                                                newImg.set({ clipPath: shapes[currentShapeIndex] });
                                                canvas.renderAll();
                                            };
            
                                            newImg.on('scaling', function () {
                                                // isScaling = true; // Set scaling flag
                                                fixClipPath();
                                            });
                                        });
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        });
                       
                    }
                }

                

            } else {
                showStaticTextElements();
            }


            // Set custom attribute with the fetched ID
            var canvasElement = document.getElementById("imageEditor1");
            canvasElement.setAttribute("data-canvas-id", temp_id);

            canvas.renderAll(); // Ensure all elements are rendered

            

        }
    }



    function getWidth(element, text) {
        const textMeasurement = new fabric.Text(text, {
            fontSize: element.fontSize,
            fontFamily: element.fontFamily,
            fontWeight: element.fontWeight,
            fontStyle: element.fontStyle,
            underline: element.underline,
            linethrough: element.linethrough,
        });
        const textWidth = textMeasurement.width;
        //console.log(`Width of '${text}':`, textWidth);
        return textWidth;
    }

    function addIconsToTextbox(textbox) {
    }

    canvas = new fabric.Canvas("imageEditor1", {
        width: 345, // Canvas width
        height: 490, // Canvas height
    });
    const ctx = canvas.getContext("2d");
    const defaultSettings = {
        fontSize: 20,
        letterSpacing: 0,
        lineHeight: 1.2,
    };

    // Save settings object (for the save functionality)
    let savedSettings = {
        fontSize: defaultSettings.fontSize,
        letterSpacing: defaultSettings.letterSpacing,
        lineHeight: defaultSettings.lineHeight,
    };

    // Function to update textbox width dynamically
    const updateTextboxWidth = (textbox) => {
        const text = textbox.text || ""; // Get current text
        const fontSize = textbox.fontSize || defaultSettings.fontSize; // Get current font size
        const fontFamily = textbox.fontFamily || 'Arial'; // Default font family
        const charSpacing = textbox.charSpacing || 0;

        const ctx = canvas.getContext('2d');
        ctx.font = `${fontSize}px ${fontFamily}`;

        const measuredTextWidth = ctx.measureText(text).width;
        const calculatedWidth = measuredTextWidth + (charSpacing / 1000 * fontSize * (text.length - 1));

        // Define a maximum width to avoid large textboxes
        const maxWidth = 400; // Adjust this value based on your layout
        const width = Math.min(calculatedWidth, maxWidth); // Cap the width
        console.log(width)

            // Handle text wrapping for large texts
            textbox.set('width', width);
            textbox.set('textAlign', 'left'); // Ensure text wraps within the textbox
            textbox.setCoords();
            
            // Set to 'clipTo' or 'overflow' if necessary based on design
            textbox.set('noScaleCache', false); // Redraw the text after resizing
            canvas.renderAll();
    };

    // Set font size function
    const setFontSize = () => {
        const newValue = fontSizeRange.value;
        fontSizeInput.value = newValue;
        fontSizeTooltip.innerHTML = `<span>${newValue}px</span>`;

        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === "textbox") {
            activeObject.set("fontSize", newValue);
            updateTextboxWidth(activeObject);
        }
    };

    // Set letter spacing function
    const setLetterSpacing = () => {
        const newValue = parseFloat(letterSpacingRange.value); // Ensure it's a number
        letterSpacingInput.value = newValue;
        letterSpacingTooltip.innerHTML = `<span>${newValue}</span>`;

        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'textbox') {
            activeObject.set('charSpacing', newValue); // Update letter spacing

            // Now call updateTextboxWidth to handle width adjustments
            updateTextboxWidth(activeObject);
        }
    };

    // Function to update line height
    const setLineHeight = () => {
        const newValue = parseFloat(lineHeightRange.value);
        lineHeightInput.value = newValue;
        lineHeightTooltip.innerHTML = `<span>${newValue}</span>`;

        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === "textbox") {
            activeObject.set("lineHeight", newValue);
            canvas.renderAll();
        }
    };

    // Event listeners for sliders and input fields
    fontSizeRange.addEventListener("input", setFontSize);
    fontSizeInput.addEventListener("input", () => {
        fontSizeRange.value = fontSizeInput.value;
        setTimeout(() => {
            setFontSize();
        }, 500);
    });

    letterSpacingRange.addEventListener("input", setLetterSpacing);
    letterSpacingInput.addEventListener("input", () => {
        letterSpacingRange.value = letterSpacingInput.value;
        setTimeout(() => {
            setLetterSpacing();
        }, 500);
    });

    lineHeightRange.addEventListener("input", setLineHeight);
    lineHeightInput.addEventListener("input", () => {
        lineHeightRange.value = lineHeightInput.value;
        setTimeout(() => {
            setLineHeight();
        }, 500);
    });

    // Save button functionality
    document.querySelector(".save-btn").addEventListener("click", function() {
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === "textbox") {
            savedSettings.fontSize = activeObject.fontSize;
            savedSettings.letterSpacing = activeObject.charSpacing / 10; // Convert back to user scale
            savedSettings.lineHeight = activeObject.lineHeight;
            alert("Settings have been saved!");
        }
    });
    const resetTextboxProperties = (object) => {
        object.set({
            fontSize: defaultSettings.fontSize,
            charSpacing: defaultSettings.letterSpacing * 10, // Adjusted for Fabric.js
            lineHeight: defaultSettings.lineHeight,
            fontFamily: "Arial",
            textAlign: "left",
            fill: "#000", // Optional: Reset text color
        });

        updateTextboxWidth(object);
    };
    // Reset button functionality
    document.querySelector(".reset-btn").addEventListener("click", function() {
        //console.log("Reset button clicked!");
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === "textbox") {
            resetTextboxProperties(activeObject); // Use the reset function
            canvas.renderAll(); // Re-render the canvas

            // Reset input fields and tooltips to default values
            fontSizeInput.value = defaultSettings.fontSize;
            fontSizeRange.value = defaultSettings.fontSize;
            fontSizeTooltip.innerHTML = `<span>${defaultSettings.fontSize}px</span>`;

            letterSpacingInput.value = defaultSettings.letterSpacing;
            letterSpacingRange.value = defaultSettings.letterSpacing;
            letterSpacingTooltip.innerHTML = `<span>${defaultSettings.letterSpacing}</span>`;

            lineHeightInput.value = defaultSettings.lineHeight;
            lineHeightRange.value = defaultSettings.lineHeight;
            lineHeightTooltip.innerHTML = `<span>${defaultSettings.lineHeight}</span>`;

            updateTextboxWidth(activeObject); // Update the textbox width to fit the default settings
            canvas.renderAll(); // Refresh the canvas to apply changes

            alert("Settings have been reset to default.");
        } else {
            alert("Please select a textbox to reset the settings.");
        }
    });

    // Initialize tooltips and values on page load
    setFontSize();
    setLetterSpacing();
    setLineHeight();

    let clrcanvas = {}
    setTimeout(function(){
        let spchoose = document.getElementsByClassName('sp-choose');
        console.log({spchoose})
            $(spchoose).click(function(){
            // alert('clicked')
            setTimeout(function(){
                console.log({clrcanvas})
                undoStack.push(clrcanvas);
      
                if(undoStack.length > 0){
                    $('#undoButton').find('svg path').attr('fill', '#0F172A');
                }
                redoStack = []; // Clear redo stack on new action
            },1000)
        })
    },1000)

    // Initialize the color picker
    $('#color-picker').spectrum({
        type: "flat",
        color: "#000000", // Default font color
        showInput: true,
        allowEmpty: true, // Allows setting background to transparent
        showAlpha: true, // Allows transparency adjustment
        preferredFormat: "hex",
        change: function(color) {
            if (color) {
                //console.log("color")
                changeColor(color.toHexString()); // Use RGB string for color changes
            } else {
                //console.log("rgba")
                changeColor('#000000'); // Handle transparency by default
            }
        }
    });

    // Function to change font or background color
    function changeColor(selectedColor) {
        const selectedColorType = document.querySelector(
            'input[name="colorType"]:checked'
        ).value;
        const activeObject = canvas.getActiveObject();
        //console.log("before update");

        //console.log(activeObject);
        if (!activeObject) {
            //console.log("No object selected");
            return;
        }

        if (activeObject.type == "textbox") {
            clrcanvas = canvas.toJSON();
            //console.log(activeObject.type);
            //console.log(activeObject.fill);
            if (selectedColorType == "font") {
                //console.log("update fill");
                //console.log(activeObject.fill);
                //console.log(activeObject.backgroundColor);
                activeObject.set("fill", selectedColor); // Change font color
                //console.log(activeObject.fill);
                //console.log(activeObject.backgroundColor);
            } else if (selectedColorType == "background") {
                //console.log("update background");
                activeObject.set("backgroundColor", selectedColor); // Change background color
            }
            canvas.renderAll(); // Re-render the canvas after color change
        }

        const activeObjec = canvas.getActiveObject();
        //console.log("ater update");

        //console.log(activeObjec);
    }

    // Update color picker based on the selected object's current font or background color
    function updateColorPicker() {
        const activeObject = canvas.getActiveObject();
        const selectedColorType = document.querySelector(
            'input[name="colorType"]:checked'
        ).value;

        if (activeObject && activeObject.type === "textbox") {
            if (selectedColorType === "font") {
                $("#color-picker").spectrum(
                    "set",
                    activeObject.fill || "#000000"
                ); // Set font color in picker
            } else if (selectedColorType === "background") {
                const bgColor =
                    activeObject.backgroundColor || 'rgba(0, 0, 0, 0)'; // Default to transparent background
                $("#color-picker").spectrum("set", bgColor); // Set current background color in picker
            }

            //console.log(selectedColorType);
            //console.log(activeObject.type);
            //console.log(activeObject.fill);
            //console.log(activeObject.backgroundColor);

            const activeObjec = canvas.getActiveObject();

            //console.log(activeObjec.fill);
            //console.log(activeObjec.backgroundColor);
        }
    }

    // Update color picker when object selection changes
    canvas.on("selection:created", updateColorPicker);
    canvas.on("selection:updated", updateColorPicker);

    // Update the color picker when the color type (font/background) changes
    $(".colorTypeInp").click(function(e) {
        e.stopPropagation();
        //console.log(123);
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === "textbox") {
            //console.log(activeObject.type);
            updateColorPicker(); // Update picker when the selected color type changes
        }
    });

    // Load background image and make it non-draggable
    document
        .getElementById("image")
        .addEventListener("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {};
                reader.readAsDataURL(file);
            }
        });

    // Call function to load data when the page loads
    loadTextDataFromDatabase();

    function hideStaticTextElements() {
        canvas.getObjects("textbox").forEach(function(textbox) {
            if (textbox.isStatic) {
                textbox.set("visible", false);
                if (textbox.copyIcon) {
                    textbox.copyIcon.set("visible", false);
                }
                if (textbox.trashIcon) {
                    textbox.trashIcon.set("visible", false);
                }
            }
        });
        canvas.renderAll();
    }

    function showStaticTextElements() {
        canvas.getObjects("textbox").forEach(function(textbox) {
            if (textbox.isStatic) {
                textbox.set("visible", true);
                if (textbox.copyIcon) {
                    textbox.copyIcon.set("visible", true);
                }
                if (textbox.trashIcon) {
                    textbox.trashIcon.set("visible", true);
                }
            }
        });
        canvas.renderAll();
    }

    function addDraggableText(left, top, textContent) {
        var text = new fabric.Textbox(textContent, {
            left: left,
            top: top,
            fontSize: 20,
            backgroundColor: 'rgba(0, 0, 0, 0)', // Set background to transparent
            fill: "#000000", // Default text color (black)
            editable: true,
            selectable: true,
            isStatic: true,
            visible: true,
            hasControls: true,
        });

        // Approximate width based on text length
        text.set("width", text.get("text").length * 10);

        // Event listener for scaling
        text.on("scaling", function() {
            var updatedFontSize =
                (text.fontSize * (text.scaleX + text.scaleY)) / 2;
            text.set("fontSize", updatedFontSize);
            canvas.renderAll();
            findTextboxCenter(text); // Find center when scaling
        });

        // Event listener for moving
        text.on("moving", function() {
            findTextboxCenter(text); // Find center when moving
        });

        // Add the textbox to the canvas
        canvas.add(text);

        addIconsToTextbox(text);
        canvas.renderAll();

        // Initial center calculation
        findTextboxCenter(text);
    }

    function calculateControlPositions(object) {
        var controlCoords = object.oCoords; // Get object control coordinates

        // Get the position of the 'mtr' control
        var mtrControl = controlCoords.mtr; // 'mtr' control (rotate)

        // Log the untransformed mtr control position
        console.log('Rotation control position (mtr):', mtrControl);

        // Transform mtr control position to apply rotation and scaling
        var transformedMtr = fabric.util.transformPoint(
            new fabric.Point(mtrControl.x, mtrControl.y),
            object.calcTransformMatrix() // apply object transformations (rotation, scaling)
        );

     
        return transformedMtr;
    } 

    function findTextboxCenter(textbox) {
        var centerX = textbox.left + textbox.width / 2;
        var centerY = textbox.top + textbox.height / 2;
        var centerPoint = textbox.getCenterPoint();
        //console.log(
          //  `Center of textbox '${textbox.text}' is at (${centerX}, ${centerY})`
       // );
        return {
            x: centerX,
            y: centerY
        };
    }

    function updateIconsPositions(textbox) {
        const angle = fabric.util.degreesToRadians(textbox.angle);
        const boundingRect = textbox.getBoundingRect(true);

        // Calculate the new position for the trash icon
        const trashOffsetX = +75; // Offset for the trash icon
        const trashOffsetY = -30; // Adjust icon's vertical position
        const trashRotatedX = textbox.left + trashOffsetX * Math.cos(angle) - trashOffsetY * Math.sin(angle);
        const trashRotatedY = textbox.top + trashOffsetX * Math.sin(angle) + trashOffsetY * Math.cos(angle);

        if (textbox.trashIcon) {
            textbox.trashIcon.left = trashRotatedX;
            textbox.trashIcon.top = trashRotatedY;
            textbox.trashIcon.angle = textbox.angle; // Sync icon rotation with textbox
        }

        // Calculate the new position for the copy icon
        const copyOffsetX = -4; // Offset for the copy icon on the left
        const copyOffsetY = -25;
        const copyRotatedX = textbox.left + copyOffsetX * Math.cos(angle) - copyOffsetY * Math.sin(angle);
        const copyRotatedY = textbox.top + copyOffsetX * Math.sin(angle) + copyOffsetY * Math.cos(angle);

        if (textbox.copyIcon) {
            textbox.copyIcon.left = copyRotatedX;
            textbox.copyIcon.top = copyRotatedY;
            textbox.copyIcon.angle = textbox.angle; // Sync icon rotation with textbox
        }

        canvas.renderAll(); // Re-render canvas to update positions
    }

    function updateIconPositions(textbox) {
        // Remove old trash and copy icons if they exist
        if (textbox.trashIcon) {
            canvas.remove(textbox.trashIcon);
            textbox.trashIcon = null; // Clear reference
        }
        if (textbox.copyIcon) {
            canvas.remove(textbox.copyIcon);
            textbox.copyIcon = null; // Clear reference
        }

        // Define SVG strings for trash and copy icons
        const trashIconSVG = `<svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_5633_67674)">
            <rect x="2.70312" y="2.37207" width="23.9674" height="23.9674" rx="11.9837" fill="white" shape-rendering="crispEdges"/>
            <path d="M19.1807 11.3502C17.5179 11.1855 15.8452 11.1006 14.1775 11.1006C13.1888 11.1006 12.2001 11.1505 11.2115 11.2504L10.1929 11.3502" stroke="#0F172A" stroke-width="0.998643" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12.939 10.8463L13.0488 10.1922C13.1287 9.7178 13.1886 9.36328 14.0325 9.36328H15.3407C16.1846 9.36328 16.2495 9.73777 16.3244 10.1971L16.4342 10.8463" stroke="#0F172A" stroke-width="0.998643" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18.1073 12.9277L17.7827 17.9559C17.7278 18.7398 17.6829 19.349 16.2898 19.349H13.0841C11.691 19.349 11.6461 18.7398 11.5912 17.9559L11.2666 12.9277" stroke="#0F172A" stroke-width="0.998643" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M13.853 16.6035H15.5158" stroke="#0F172A" stroke-width="0.998643" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M13.4385 14.6055H15.9351" stroke="#0F172A" stroke-width="0.998643" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            </svg>`;

        const copyIconSVG = `<svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_5633_67676)">
            <rect x="2.64893" y="2.37207" width="23.9674" height="23.9674" rx="11.9837" fill="white" shape-rendering="crispEdges"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6283 16.3538V10.3619C17.6283 9.81039 17.1812 9.36328 16.6297 9.36328H10.6378C10.0863 9.36328 9.63916 9.81039 9.63916 10.3619V16.3538C9.63916 16.9053 10.0863 17.3524 10.6378 17.3524H16.6297C17.1812 17.3524 17.6283 16.9053 17.6283 16.3538ZM10.6379 10.362H16.6298V16.3539H10.6379V10.362ZM18.6271 17.3525V11.3607C19.1786 11.3607 19.6257 11.8078 19.6257 12.3593V17.3525C19.6257 18.4556 18.7315 19.3498 17.6284 19.3498H12.6352C12.0837 19.3498 11.6366 18.9027 11.6366 18.3512H17.6284C18.1799 18.3512 18.6271 17.9041 18.6271 17.3525Z" fill="#0F172A"/>
            </g>
            </svg>`;

        // Load trash icon from SVG string and position
        fabric.loadSVGFromString(trashIconSVG, function(objects, options) {
            const trashIcon = fabric.util.groupSVGElements(objects, options);
            trashIcon.set({
                left: textbox.left + textbox.width * textbox.scaleX - 20,
                top: textbox.top - 20,
                selectable: false,
                evented: true,
                hasControls: false,
            });
            textbox.trashIcon = trashIcon;

            // Attach delete functionality to trash icon
            trashIcon.on("mousedown", function() {
                //console.log("Trash icon clicked! Deleting textbox.");
                deleteTextbox(textbox);
            });

            // Add trash icon to canvas
            canvas.add(trashIcon);
            canvas.bringToFront(trashIcon);
        });

        // Load copy icon from SVG string and position
        fabric.loadSVGFromString(copyIconSVG, function(objects, options) {
            const copyIcon = fabric.util.groupSVGElements(objects, options);
            copyIcon.set({
                left: textbox.left - 25,
                top: textbox.top - 20,
                selectable: false,
                evented: true,
                hasControls: false,
            });
            textbox.copyIcon = copyIcon;

            // Attach clone functionality to copy icon
            copyIcon.on("mousedown", function() {
                //console.log("Copy icon clicked!");
                cloneTextbox(textbox);
            });

            // Add copy icon to canvas
            canvas.add(copyIcon);
            canvas.bringToFront(copyIcon);
        });

        // Ensure textbox and icons stay visible
        canvas.bringToFront(textbox);
        canvas.renderAll();
    }

    // Function to add icons to a textbox

    function deleteTextbox() {            
        canvas.remove(canvas.getActiveObject());           
        canvas.renderAll();
    }

    $(".removeShapImage").click(function(){
        // $('.resize-handle').hide();
        // $("#imageWrapper").hide();
        $(this).hide();
        $('.uploadShapImage').show();
        $("#image").attr("src",shapeImageUrl);
    })

    $(document).on('change','.uploadShapImage',function(event){
        event.preventDefault();

        var file = event.target.files[0]; // Get the first file (the selected image)
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#user_image").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(file);
            $('.uploadShapImage').hide();
            $('.removeShapImage').show();
            
        }
    })

    function cloneTextbox() {
        let originalTextbox = canvas.getActiveObject()
        const clonedTextbox = new fabric.Textbox(originalTextbox.text, {
            left: originalTextbox.left + 30, // Offset position
            top: originalTextbox.top + 30, // Offset position
            fontSize: originalTextbox.fontSize,
            fill: originalTextbox.fill,
            width: originalTextbox.width,
            height: originalTextbox.height,
            fontFamily: originalTextbox.fontFamily,
            originX: originalTextbox.originX,
            originY: originalTextbox.originY,
            hasControls: true,
            hasBorders: true,
            lockScalingFlip: true,
            editable: true,
            borderColor: '#2DA9FC',
            // cornerColor: 'red',
            cornerColor: '#fff',
            cornerSize: 10,
            transparentCorners: false,
            isStatic: true,
            backgroundColor: 'rgba(0, 0, 0, 0)',
        });


        canvas.add(clonedTextbox);

        // Add icons to the cloned textbox

        canvas.renderAll();
        setControlVisibilityForAll()
    }

    // Handle keyboard events for delete and copy
    function handleKeyboardEvents(e) {
        if (e.key === "Delete") {
            const activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === "textbox") {
                deleteTextbox(activeObject);
            }
        } else if (e.ctrlKey && e.key === "c") {
            const activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === "textbox") {
                cloneTextbox(activeObject);
            }
        }
    }

    // Add event listener for keyboard events
    document.addEventListener("keydown", handleKeyboardEvents);

    function updateSelectedTextProperties() {
        var fontSize = parseInt(document.getElementById("fontSize").value, 10);
        var fontColor = document.getElementById("fontColor").value;
        addToUndoStack(canvas);
        var activeObject = canvas.getActiveObject();

        if (activeObject && activeObject.type === "textbox") {
            // Update text properties
            activeObject.set({
                fontSize: fontSize,
                fill: fontColor,
            });
            activeObject.setCoords(); // Update coordinates

            // Log the updated properties
            //console.log("Updated Font Size: " + activeObject.fontSize);
            //console.log("Updated Font Color: " + activeObject.fill);

            canvas.renderAll();
             // Save state after updating properties
        }
    }

    // document.getElementById('fontSize').addEventListener('change', updateSelectedTextProperties);
    // document.getElementById('fontColor').addEventListener('input', updateSelectedTextProperties);

    // canvas.on("mouse:down", function(options) {
    //     if (options.target && options.target.type === "textbox") {
    //         canvas.setActiveObject(options.target);
    //     } else {
    //         canvas.getObjects("textbox").forEach(function(tb) {
    //             if (tb.trashIcon) tb.trashIcon.set("visible", false);
    //             if (tb.copyIcon) tb.copyIcon.set("visible", false);
    //         });
    //     }
    // });

    function discardIfMultipleObjects(options) {

        if (options.target !== undefined && options.target?._objects && options.target?._objects.length > 1) {
            //console.log('Multiple objects selected:', options.target);
            canvas.discardActiveObject();
            canvas.renderAll(); // Ensure the canvas is refreshed
        }

        const activeObjects = canvas.getActiveObjects(); // Get all selected objects
        //console.log(activeObjects)
        if (activeObjects.length > 1) {
            //console.log('Multiple objects selected:', activeObjects);
            canvas.discardActiveObject(); // Discard active selection
            canvas.renderAll(); // Refresh the canvas
        }

    }

    canvas.on('mouse:down', function(options) {
        discardIfMultipleObjects(options);
        if (options.target && options.target.type === 'textbox') {
            canvas.setActiveObject(options.target);
            addIconsToTextbox(options.target)
        } else {
            // alert();
            canvas.getObjects('textbox').forEach(function(tb) {
                if (tb.trashIcon) tb.trashIcon.set('visible', false);
                if (tb.copyIcon) tb.copyIcon.set('visible', false);
            });
        }
    });

    canvas.on('mouse:up', function(options) {
        discardIfMultipleObjects(options);
    });

    document
        .getElementById("addTextButton")
        .addEventListener("click", function() {
            addEditableTextbox(100, 100, "EditableText"); // You can set the initial position and default text
        });

        function addEditableTextbox(left, top, textContent) {

            var textbox = new fabric.Textbox(textContent, {
                left: left,
                top: top,
                // width: 100,
                fontSize: 20,
                backgroundColor: 'rgba(0, 0, 0, 0)', // Set background to transparent
                textAlign: 'center',
                fill: '#0a0b0a',
                editable: true,
                selectable: true,
                hasControls: true,
                borderColor: '#2DA9FC',
                cornerColor: '#fff',
                cornerStyle:'circle',
                cornerSize: 10,
                transparentCorners: false,
                textAlign:'center',
            });
            textbox.setControlsVisibility({
                mt: false, // Hide middle top control
                mb: false, // Hide middle bottom control
                bl: true, // Hide bottom left control
                br: true, // Hide bottom right control
                tl: true, // Hide top left control
                tr: true, // Hide top right control
                ml: true,  // Show middle left control
                mr: true   // Show middle right control
            });

            canvas.add(textbox);
            canvas.setActiveObject(textbox);
            
            canvas.renderAll();
        }

    document.getElementById('AbrilFatfaceButton').addEventListener('click', function() {
        //console.log("fontname")
        loadAndUse("AbrilFatface-Regular");
    });
    document.getElementById('AdleryProButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("AdleryPro-Regular");


    });
    document.getElementById('AgencyFBButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("AgencyFB-Bold");


    });
    document.getElementById('AlexBrushButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("AlexBrush-Regular");


    });
    document.getElementById('AlluraButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Allura-Regular");


    });
    // document.getElementById('BotanicaScript-RegularButton').addEventListener('click', function() {
    //     //console.log("fontname")

    //     loadAndUse("BotanicaScript-Regular");


    // });
    document.getElementById('ArcherButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("ArcherBold");


    });
    document.getElementById('Archer-BookButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Archer-Book");


    });
    document.getElementById('Archer-BookItalicButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Archer-BookItalic");


    });
    document.getElementById('Archer-ExtraLightButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Archer-ExtraLight");


    });
    document.getElementById('Archer-HairlineButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Archer-Hairline");


    });
    document.getElementById('Bebas-RegularButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Bebas-Regular");


    });
    document.getElementById('BookAntiquaButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("BookAntiqua");


    });
    document.getElementById('CandyCaneUnregisteredButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("CandyCaneUnregistered");


    });
    document.getElementById('CarbonBl-RegularButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("CarbonBl-Regular");


    });
    document.getElementById('CarmenSans-ExtraBoldButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("CarmenSans-ExtraBold");


    });
    document.getElementById('CarmenSans-RegularButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("CarmenSans-Regular");


    });
    document.getElementById('ChristmasCookiesButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("ChristmasCookies");


    });
    document.getElementById('Bungee-RegularButton').addEventListener('click', function() {
        //console.log("fontname")

        loadAndUse("Bungee-Regular");


    });

    canvas.on('object:scaling', function (e) {
        var activeObject = e.target;

        // Check if the scaled object is the textbox
        if (activeObject && activeObject.type === 'textbox') {
            // Get the current font size
            var currentFontSize = activeObject.fontSize;
            console.log("Current font size: " + currentFontSize);

            // Calculate new font size based on scale factor
            var newFontSize = currentFontSize * activeObject.scaleX; // Adjust the font size based on the horizontal scaling factor
            const textMeasurement = new fabric.Text(activeObject.text, {
                fontSize: newFontSize,
                fontFamily: activeObject.fontFamily,
                fontWeight: activeObject.fontWeight,
                fontStyle: activeObject.fontStyle,
                underline: activeObject.underline,
                linethrough: activeObject.linethrough,
            });
            const textWidth = textMeasurement.width;
            // Set the new font size and reset scale
            activeObject.set({
                fontSize: newFontSize,
                scaleX: 1, // Reset scaleX to 1 to prevent cumulative scaling
                scaleY: 1,  // Reset scaleY to 1 if you want to keep uniform scaling
                width: textWidth + 5,
                textAlign:activeObject.textAlign,
            });

            // Re-render the canvas to apply the changes
            canvas.renderAll();

            console.log("Updated font size: " + newFontSize);
        }
    }); 
    //     textElement.style.fontFamily = 'Allura'; // Change to Allura font
    // });
    function loadAndUse(font) {
        var myfont = new FontFaceObserver(font);
        addToUndoStack(canvas);
        myfont
            .load()
            .then(function() {
                // When font is loaded, use it.
                var activeObject = canvas.getActiveObject();
                //console.log(activeObject.type);
                if (activeObject && activeObject.type === "textbox") {
                    activeObject.set({
                        fontFamily: font,
                    });
                    activeObject.initDimensions();
                    canvas.requestRenderAll();
                    //console.log("applied font" + font);
                    //console.log(canvas.getActiveObject());
                } else {
                    alert("No object selected");
                }
            })
            .catch(function(e) {
                //console.log(e);
                alert("Font loading failed: " + font);
            });
    }

    function setControlVisibilityForAll() {  
        canvas.getObjects().forEach((obj) => {
            console.log(obj);
            var currentFontSize = obj.fontSize;
            console.log("Current font size: " + currentFontSize);

            // Calculate new font size based on scale factor
            var newFontSize = currentFontSize * obj.scaleX; // Adjust the font size based on the horizontal scaling factor
            const textMeasurement = new fabric.Text(obj.text, {
                fontSize: newFontSize,
                fontFamily: obj.fontFamily,
                fontWeight: obj.fontWeight,
                fontStyle: obj.fontStyle,
                underline: obj.underline,
                linethrough: obj.linethrough,
            });
            const textWidth = textMeasurement.width;

            obj.set('width',textWidth);
            obj.set('fontSize',newFontSize);
          
            obj.setControlsVisibility({
                mt: false, 
                mb: false, 
                bl: true,  
                br: true,  
                tl: true, 
                tr: true, 
                ml: true,  
                mr: true   
            });
            
            obj.set('transparentCorners', false);
            obj.set('borderColor', "#2DA9FC");
            obj.set('cornerSize', 10);
            obj.set('cornerColor', "#fff");
            // Set text alignment if the object is a text-based object
            if (obj.type === 'textbox' || obj.type === 'text') {
                obj.set('textAlign', 'center');  // Set text alignment to center
            }

            obj.on('rotating', function () {
                // Get the bounding rectangle of the textboxbox
                var boundingRect = obj.getBoundingRect();
                var centerX = boundingRect.left + boundingRect.width / 2;
                var centerY = boundingRect.top + boundingRect.height / 2;
                var rotationAngle = obj.angle;
                // console.log('Rotated Position:', { centerX: centerX, centerY: centerY, rotation: rotationAngle });
            });
        });    
        canvas.renderAll();
    }

    function executeCommand(command, font = null) {
        var activeObject = canvas.getActiveObject();

        if (!activeObject || activeObject.type !== 'textbox') {
            return; // No object or not a textbox, so do nothing
        }
        console.log('add to undo')
        addToUndoStack(canvas); // Save state for undo/redo functionality

        // Commands object to handle various styles and operations
        const commands = {
            bold: () => activeObject.set('fontWeight', activeObject.fontWeight === 'bold' ? '' : 'bold'),
            italic: () => activeObject.set('fontStyle', activeObject.fontStyle === 'italic' ? '' : 'italic'),
            underline: () => activeObject.set('underline', !activeObject.underline),
            setLineHeight: (value) => activeObject.set('lineHeight', value),
            strikeThrough: () => activeObject.set('linethrough', !activeObject.linethrough),
            removeFormat: () => {
                activeObject.set({
                    fontWeight: '',
                    fontStyle: '',
                    underline: false,
                    linethrough: false,
                    fontFamily: 'Arial'
                });
            },
            fontName: (font) => {
                if (font) {
                    console.log('load and use command')
                    // loadAndUse(font);
                }
            },
            justifyLeft: () => activeObject.set('textAlign', 'left'),
            justifyCenter: () => activeObject.set('textAlign', 'center'),
            justifyRight: () => activeObject.set('textAlign', 'right'),
            justifyFull: () => activeObject.set('textAlign', 'justify'),
            uppercase: () => activeObject.set('text', activeObject.text.toUpperCase()),
            lowercase: () => activeObject.set('text', activeObject.text.toLowerCase()),
            capitalize: () => {
                const capitalizedText = activeObject.text.replace(/\b\w/g, char => char.toUpperCase());
                activeObject.set('text', capitalizedText);
            }
        };

        // Execute the corresponding command
        if (commands[command]) {
            commands[command](font); // Pass font to fontName if needed
           

            canvas.renderAll(); // Re-render canvas after change
        }
    }

    document.querySelectorAll('[data-command]').forEach(function(button) {
        button.addEventListener('click', function() {
            const command = button.getAttribute('data-command');
            if(command=="fontName" || command=="undo" || command=="redo"){
                return;
            }
            executeCommand(this.getAttribute('data-command'));
        });
    });

    let undoStack = [];
    let redoStack = [];
    let isAddingToUndoStack = 0;
    function createShapes(img) {
                const imgWidth = img.width;
                const imgHeight = img.height;
                const starScale = Math.min(imgWidth, imgHeight) / 2;
                const starPoints = [
                    { x: 0, y: -starScale },
                    { x: starScale * 0.23, y: -starScale * 0.31 }, 
                    { x: starScale, y: -starScale * 0.31 }, 
                    { x: starScale * 0.38, y: starScale * 0.12 }, 
                    { x: starScale * 0.58, y: starScale }, 
                    { x: 0, y: starScale * 0.5 }, 
                    { x: -starScale * 0.58, y: starScale }, 
                    { x: -starScale * 0.38, y: starScale * 0.12 }, 
                    { x: -starScale, y: -starScale * 0.31 }, 
                    { x: -starScale * 0.23, y: -starScale * 0.31 } 
                ];

                return [
                    new fabric.Rect({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Circle({ radius: Math.min(imgWidth, imgHeight) / 2, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Triangle({ width: imgWidth, height: imgHeight, originX: 'center', originY: 'center', angle: 0 }),
                    new fabric.Polygon(starPoints, { originX: 'center', originY: 'center', angle: 0 })
                ];
            }
    function setControlVisibilityForAll() {  
        canvas.getObjects().forEach((obj) => {
            obj.setControlsVisibility({
                mt: false, 
                mb: false, 
                bl: true,  
                br: true,  
                tl: true, 
                tr: true, 
                ml: true,  
                mr: true   
            });
            
            obj.set('transparentCorners', false);
            obj.set('borderColor', "#2DA9FC");
            obj.set('cornerSize', 10);
            obj.set('cornerColor', "#fff");
            obj.set('cornerStyle', "circle");
            // Set text alignment if the object is a text-based object
            if (obj.type === 'textbox' || obj.type === 'text') {
                obj.set('textAlign', 'center');  // Set text alignment to center
            }
            if (obj.type === 'image') {
                console.log(obj);
                        let currentShapeIndex = 0;
                        obj.crossOrigin = "anonymous";

                        let defaultShape = obj.clipPath.type; 
                        if (defaultShape === 'polygon') {
                            defaultShape = 'star'; 
                        }
                        const shapeIndexMap = {
                            'rectangle': 0,
                            'circle': 1,
                            'triangle': 2,
                            'star': 3
                        };
                    currentShapeIndex = shapeIndexMap[defaultShape] || 0; 
                    shapes = createShapes(obj);
                    obj.set({ clipPath: shapes[currentShapeIndex] });
                    obj.on('mouseup', function(event) {
                    if(event?.transform?.action === 'drag' && event.transform.actionPerformed === undefined){
                        currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
                        obj.set({ clipPath: shapes[currentShapeIndex] });
                        canvas.renderAll();
                    }
                });

            }

            obj.on('rotating', function () {
                // Get the bounding rectangle of the textboxbox
                var boundingRect = obj.getBoundingRect();
                var centerX = boundingRect.left + boundingRect.width / 2;
                var centerY = boundingRect.top + boundingRect.height / 2;
                var rotationAngle = obj.angle;
                // console.log('Rotated Position:', { centerX: centerX, centerY: centerY, rotation: rotationAngle });
            });

            
        });    
        canvas.renderAll();
    }

  
    function addToUndoStack(canvas) {          
        undoStack.push(canvas.toJSON());          
        if(undoStack.length > 0){
            $('#undoButton').find('svg path').attr('fill', '#0F172A');
        }
        redoStack = [];        
    }

    function undo() {        
        if (undoStack.length > 0) {  // Ensure at least one previous state exists
           
            redoStack.push(canvas.toJSON()); // Save current state to redo stack
            const lastState = undoStack.pop(); // Get the last state to undo
            canvas.loadFromJSON(lastState, function () {

                canvas.renderAll(); // Render the canvas after loading state
              
            });            
            if(redoStack.length > 0){
                $('#redoButton').find('svg path').attr('fill', '#0F172A');  
            }
            setTimeout(function(){
                setControlVisibilityForAll()
            },1000)
        }else{
            $('#undoButton').find('svg path').attr('fill', '#CBD5E1');  
        }
    }

    function redo() {
        if (redoStack.length > 0) {
          
            undoStack.push(canvas.toJSON()); // Save current state to undo stack
            const nextState = redoStack.pop(); // Get the next state to redo
            canvas.loadFromJSON(nextState, function () {
                
                canvas.renderAll(); // Render the canvas after loading state
               
            });
            if(undoStack.length > 0 ){
                $('#undoButton').find('svg path').attr('fill', '#0F172A');
            }
            $('#redoButton').find('svg path').attr('fill', '#0F172A');  
            setTimeout(function(){
                setControlVisibilityForAll()
            },1000)
        }else{
            $('#redoButton').find('svg path').attr('fill', '#CBD5E1');  
        }
    }


 
    $("#undoButton").click(function(){
        undo();
    })
    $("#redoButton").click(function(){
        redo();
    })


        $(".slider_photo").on("change", function(event) {
            var file = event.target.files[0]; // Get the first file (the selected image)
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".photo-slider-1").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
                $(".design-sidebar").addClass("d-none");
                $(".design-sidebar_7").removeClass("d-none");
                $("#sidebar").addClass("design-sidebar_7");
                $(".close-btn").attr("data-id", "design-sidebar_7");
            }
        });

        $(".slider_photo_2").on("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                $(".photo-slider-2").show();
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".photo-slider-2").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
        $(".slider_photo_3").on("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                $(".photo-slider-3").show();
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".photo-slider-3").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
        // $(document).on("click", ".delete-slider-1", function () {
        //     $(".photo-slider-1").hide();
        // });
        // $(document).on("click", ".delete-slider-2", function () {
        //     $(".photo-slider-2").hide();
        // });
        // $(document).on("click", ".delete-slider-3", function () {
        //     $(".photo-slider-3").hide();
        // });

        $(document).on("click", ".save-slider-image", function() {
            var imageSources = [];
            // $(".slider_img").each(function () {
            //     imageSources.push($(this).attr("src"));
            // });

            $(".slider_img").each(function() {
                var src = $(this).attr("src");
                if (src !== "") {
                    imageSources.push({
                        src: $(this).attr("src"),
                        deleteId: $(this).data("delete")
                    });
                }
            });
            //console.log(imageSources);
            if(imageSources.length > 0){
                $('#loader').css('display', 'block');
                $.ajax({
                    url: base_url + "event/save_slider_img",
                    method: "POST",
                    data: {
                        imageSources: imageSources,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        var savedImages = response.images;
                        eventData.slider_images = savedImages;
                        //console.log(eventData);
                        $('#loader').css('display', 'none');
                        toastr.success('Slider Image saved Successfully');
                    },
                    error: function(xhr, status, error) {},
                });
            }
        });

        $(document).on("click", ".delete_silder", function(e) {
            e.preventDefault();
            var delete_id = $(this).parent().find('.slider_img').data("delete");
            var src = $(this).parent().find('.slider_img').attr("src");
            if (src != "") {
                $('#loader').css('display', 'block');
                var $this = $(this);
                var check_slider_img = eventData.slider_images;
                var matchFound = false;
                $.each(check_slider_img, function(index, slider) {
                    if (slider.deleteId == delete_id) {
                        matchFound = true;
                        return false;
                    }
                });
                if (matchFound) {
                    $.ajax({
                        url: base_url + "event/delete_slider_img",
                        method: "POST",
                        data: {
                            delete_id: delete_id,
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(response) {
                            $this.parent().find('.slider_img').attr('src', '');
                            $(".photo-slider-" + delete_id).hide();
                            toastr.success('Slider Image Deleted Successfully')
                            $('#loader').css('display', 'none');

                        },
                        error: function(xhr, status, error) {},
                    });
                } else {
                    $(this).parent().find('.slider_img').attr('src', '');
                    $(".photo-slider-" + delete_id).hide();
                    $('#loader').css('display', 'none');
                    toastr.success('Slider Image Deleted Successfully')

                }

            }

        });
   


   
        // var canvasElement = new fabric.Canvas('imageEditor', {
        //     width: 500, // Canvas width
        //     height: 500, // Canvas height
        //     cornerSize: 6,
        // });
//     function updateClipPath(imageUrl, element) {

//         const imageWrapper = document.getElementById('imageWrapper');
//         const imgElement = document.getElementById('user_image');
//         imgElement.src = imageUrl;
//         if(!canvasElement){
//         var canvasElement = new fabric.Canvas('imageEditor', {
//                     width: 500, // Canvas width
//                     height: 500, // Canvas height
//                     cornerSize: 6,
//         });
// }
//         //console.log(imageWrapper);
//         // If a current image exists on canvas, remove it
//         console.log(canvasElement)
//         if (currentImage) {
//             canvasElement.remove(currentImage);
//         }

//         // Handle previous image and trash icon
//         if (oldImage != null) {
//             canvasElement.remove(oldImage.trashIcon);
//             oldImage.trashIcon = null;
//             canvasElement.renderAll();
//         }

//         imageWrapper.style.display = 'block';
//         // imageWrapper.style.left = element.left;
//         // imageWrapper.style.top = element.top;

//         let canvasEL = document.getElementById('imageEditor1')
//         const canvasRect = canvasEL.getBoundingClientRect();

//         //console.log(canvasRect.left)
//         //console.log(canvasRect.top)
//         //console.log(element.centerX)
//         //console.log(element.centerY)
//         //console.log(element.height)
//         //console.log(element.height)

//         let left = element.centerX !== undefined ? `${element.centerX  + canvasRect.left}px` : '50%';
//         let top = element.centerY !== undefined ? `${element.centerY + canvasRect.top}px` : '50%';
//         //console.log({
//         //     left
//         // })
//         //console.log({
//         //     imageWrapper
//         // })

//         // Set the calculated position to imageWrapper
//         imageWrapper.style.left = left;
//         imageWrapper.style.top = top;

//         imgElement.onload = function() {
//             // Get image dimensions and scale it
//             const imgInstance = new fabric.Image(imgElement, {
//                 selectable: true,
//                 hasControls: true,
//                 hasBorders: true,

//                 borderColor: "#2DA9FC",
//                 cornerColor: "#fff",
//                 transparentCorners: false,
//                 lockUniScaling: true,
//                 scaleX: 600 / imgElement.width,
//                 scaleY: 600 / imgElement.height,
//                 cornerSize: 10,
//                 cornerStyle: 'circle',
//             });
//             shape = element.shape;
//             current_shape = shape;
//             canvasElement.add(imgInstance);
//             // addIconsToImage(imgInstance);
//             drawCanvas();

//             // Refresh canvas
//             canvasElement.renderAll();

//             // Update the image with the shape based on the provided element data
//             if (element.shape) {
//                 applyClipPath(imgInstance, element);
//             }

//             // Image mouseup event to change shape or update position
//             imgInstance.on('mouseup', function(options) {
//                 if (options.target) {
//                     // Change shape logic
//                     currentShapeIndex = (currentShapeIndex + 1) % shapes.length;
//                     const nextShape = shapes[currentShapeIndex];
//                     element.shape = nextShape;
//                     console.log(1)
//                     updateClipPath(data, element); // Update the image with the new shape
//                 }
//             });

//             // Update canvas on movement or scaling
//             imgInstance.on('moving', function() {
//                 isImageDragging = true;
//                 element.centerX = imgInstance.left;
//                 element.centerY = imgInstance.top;

//                 updatedOBJImage = {
//                     centerX: imgInstance.left,
//                     centerY: imgInstance.top,
//                 };
//             });

//             imgInstance.on('scaling', function() {
//                 element.width = imgInstance.width * imgInstance.scaleX;
//                 element.height = imgInstance.height * imgInstance.scaleY;

//                 updatedOBJImage = {
//                     width: imgInstance.width * imgInstance.scaleX,
//                     height: imgInstance.height * imgInstance.scaleY
//                 };
//             });

//             currentImage = imgInstance; // Track current image on canvas
//             oldImage = imgInstance;
//             // $('.photo-slider-wrp').hide()
//         };

//         imgElement.onerror = function(e) {
//             console.error("Failed to load image.", e);
//         };
//     }

    // Helper function to apply clip path based on shape
    // function applyClipPath(image, element) {
    //     const containerWidth = 150;
    //     const containerHeight = 200;

    //     let clipPath;
    //     switch (element.shape) {
    //         case 'circle':
    //             clipPath = new fabric.Circle({
    //                 radius: Math.min(containerWidth, containerHeight) / 2,
    //                 originX: 'center',
    //                 originY: 'center'
    //             });
    //             break;
    //         case 'star':
    //             clipPath = new fabric.Path(
    //                 'M 50,0 L 61,35 L 98,35 L 68,57 L 79,91 L 50,70 L 21,91 L 32,57 L 2,35 L 39,35 z', {
    //                     scaleX: (image.width * image.scaleX) / 100,
    //                     scaleY: (image.height * image.scaleY) / 100,
    //                     originX: 'center',
    //                     originY: 'center'
    //                 }
    //             );
    //             break;
    //         case 'heart':
    //             const heartPath = [
    //                 'M', 0, 0,
    //                 'C', -containerWidth / 3, -containerHeight / 3, -containerWidth / 3, containerHeight / 6, 0, containerHeight / 5,
    //                 'C', containerWidth / 3, containerHeight / 6, containerWidth / 3, -containerHeight / 3, 0, 0
    //             ].join(' ');
    //             clipPath = new fabric.Path(heartPath, {
    //                 originX: 'center',
    //                 originY: 'center'
    //             });
    //             break;
    //         default:
    //             break;
    //     }

    //     // Set clipping path for the image
    //     image.set({
    //         clipPath: clipPath
    //     });

    //     canvasElement.renderAll();
    // }


    // const imageWrapper = document.getElementById('imageWrapper');
    // const canvasElement = new fabric.Canvas('imageEditor', {
    //     width: 500, // Canvas width
    //     height: 500, // Canvas height
    // });

    // const resizeHandles = {
    //     topLeft: document.querySelector('.resize-handle.top-left'),
    //     topRight: document.querySelector('.resize-handle.top-right'),
    //     bottomLeft: document.querySelector('.resize-handle.bottom-left'),
    //     bottomRight: document.querySelector('.resize-handle.bottom-right'),
    //     topCenter: document.querySelector('.resize-handle.top-center'),
    //     bottomCenter: document.querySelector('.resize-handle.bottom-center'),
    //     leftCenter: document.querySelector('.resize-handle.left-center'),
    //     rightCenter: document.querySelector('.resize-handle.right-center')
    // };

    // let isDragging = false;
    // let isResizing = false;
    // let startWidth, startHeight, startX, startY, activeHandle;
    // let offsetX, offsetY;
    // let shape = 'rectangle'; // Default shape
    // current_shape = shape;
    // let shapeChangedDuringDrag = false; // Flag to track shape change
    // let imageUploaded = false; // Flag to track if image has been uploaded

    // function startResize(event, handle) {
    //     const userImageElement = document.getElementById('user_image');

    //     isResizing = true;
    //     startWidth = userImageElement.clientWidth;
    //     startHeight = userImageElement.clientHeight;
    //     startX = event.clientX;
    //     startY = event.clientY;
    //     activeHandle = handle;
    //     event.stopPropagation();
    // }

    // function resize(event) {
    //     if (isResizing) {
    //     const userImageElement = document.getElementById('user_image');

    //         let newWidth, newHeight;

    //         if (activeHandle === resizeHandles.bottomRight) {
    //             newWidth = startWidth + (event.clientX - startX);
    //             newHeight = startHeight + (event.clientY - startY);
    //         } else if (activeHandle === resizeHandles.bottomLeft) {
    //             newWidth = startWidth - (event.clientX - startX);
    //             newHeight = startHeight + (event.clientY - startY);
    //             imageWrapper.style.left = `${event.clientX}px`;
    //         } else if (activeHandle === resizeHandles.topRight) {
    //             newWidth = startWidth + (event.clientX - startX);
    //             newHeight = startHeight - (event.clientY - startY);
    //             imageWrapper.style.top = `${event.clientY}px`;
    //         } else if (activeHandle === resizeHandles.topLeft) {
    //             newWidth = startWidth - (event.clientX - startX);
    //             newHeight = startHeight - (event.clientY - startY);
    //             imageWrapper.style.left = `${event.clientX}px`;
    //             imageWrapper.style.top = `${event.clientY}px`;
    //         } else if (activeHandle === resizeHandles.topCenter) {
    //             newHeight = startHeight - (event.clientY - startY);
    //             imageWrapper.style.top = `${event.clientY}px`;
    //         } else if (activeHandle === resizeHandles.bottomCenter) {
    //             newHeight = startHeight + (event.clientY - startY);
    //         } else if (activeHandle === resizeHandles.leftCenter) {
    //             newWidth = startWidth - (event.clientX - startX);
    //             imageWrapper.style.left = `${event.clientX}px`;
    //         } else if (activeHandle === resizeHandles.rightCenter) {
    //             newWidth = startWidth + (event.clientX - startX);
    //         }

    //         if (newWidth) userImageElement.style.width = `${newWidth}px`;
    //         if (newHeight) userImageElement.style.height = `${newHeight}px`;
    //     }
    // }

    // function handleMouseDown(event) {
    //     ////console.logevent);  
    //     const canvas = document.querySelector('.new');

    //     canvasRect = canvas.getBoundingClientRect();

    //     if (event.target.classList.contains('resize-handle')) {
    //         startResize(event, event.target);
    //     } else {
    //         event.preventDefault(); // Prevent default behavior during dragging (text selection)
    //         isDragging = true;
    //         offsetX = event.clientX - imageWrapper.offsetLeft;
    //         offsetY = event.clientY - imageWrapper.offsetTop;
    //         shapeChangedDuringDrag = false; // Reset flag on new drag start
    //     }
    // }

    // function handleMouseMove(event) {
    //     ////console.logevent);
    //     if (isDragging) {
    //     const userImageElement = document.getElementById('user_image');

    //         const canvas = document.querySelector('.new');
    //         const canvasRect = canvas.getBoundingClientRect();
    //         let newX = event.clientX - offsetX;
    //         let newY = event.clientY - offsetY;

    //         // Ensure the image stays within the canvas boundaries
    //         if (newX < canvasRect.left) newX = canvasRect.left;
    //         if (newX + userImageElement.clientWidth > canvasRect.right)
    //             newX = canvasRect.right - userImageElement.clientWidth;
    //         if (newY < canvasRect.top) newY = canvasRect.top;
    //         if (newY + userImageElement.clientHeight > canvasRect.bottom)
    //             newY = canvasRect.bottom - userImageElement.clientHeight;

    //         imageWrapper.style.left = `${newX}px`;
    //         imageWrapper.style.top = `${newY}px`;
    //         shapeChangedDuringDrag = true; // Set flag if dragging occurs
    //     } else if (isResizing) {
    //         resize(event);
    //     }
    // }


    // function handleMouseUp(event) {
    //     const userImageElement = document.getElementById('user_image');

    //     if (event.target === userImageElement && !shapeChangedDuringDrag) {
    //         // Cycle through shapes
    //         const shapes = ['rectangle', 'circle', 'star', 'rounded-border', 'heart'];
    //         const currentIndex = shapes.indexOf(shape);
    //         shape = shapes[(currentIndex + 1) % shapes.length];
    //         current_shape = shape;
    //         ////console.log`Shape changed to: ${shape}`); // Log shape change

    //         drawCanvas();
    //     }

    //     isDragging = false;
    //     isResizing = false;
    // }

    // function drawCanvas() {
    //     const userImageElement = document.getElementById('user_image');

    //     ////console.loguserImageElement);
    //     userImageElement.style.clipPath = '';

    //     switch (shape) {
    //         case 'rectangle':
    //             break;
    //         case 'circle':
    //             userImageElement.style.clipPath = 'circle(50% at 50% 50%)';
    //             break;
    //         case 'star':
    //             userImageElement.style.clipPath =
    //                 'polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%)';
    //             break;
    //         case 'rounded-border':
    //             userImageElement.style.clipPath = 'inset(0 round 20px)';
    //             break;
    //         case 'heart':
    //             userImageElement.style.clipPath = 'url(#heartClipPath)';
    //             break;
    //         default:
    //             break;
    //     }
    // }

}




function getTextDataFromCanvas() {
    var objects = canvas.getObjects();
    console.log(objects);
    var textData = [];
    var shapeImageData = [];
    objects.forEach(function(obj) {
        if (obj.type === "textbox") {
            console.log(obj.underline);
            var centerPoint = obj.getCenterPoint();     
            textData.push({
                text: obj.text,
                left: obj.left,
                top: obj.top,
                fontSize: parseInt(obj.fontSize),
                fill: obj.fill,
                centerX: centerPoint.x, // Use the center point from getCenterPoint()
                centerY: centerPoint.y,
                dx: obj.left, // Calculate dx
                dy: obj.top, // Calculate dy
                backgroundColor: obj.backgroundColor,
                fontFamily: obj.fontFamily,
                textAlign: obj.textAlign,
                fontWeight: obj.fontWeight,
                fontStyle: obj.fontStyle,
                underline: obj.underline,
                linethrough: obj.linethrough,
                date_formate: obj.date_formate, // Include date_formate if set
                rotation: obj.angle

            });
        }
        if (obj.type === "image") {
            var centerX = obj.left + obj.getScaledWidth() / 2; // Use getScaledWidth()
            var centerY = obj.top + obj.getScaledHeight() / 2; // Use getScaledHeight()

            shapeImageData = {
                shape: obj.clipPath ? obj.clipPath.type : 'none', // Handle case when clipPath is null
                centerX: centerX,
                centerY: centerY,
                width: obj.getScaledWidth(), // Get the scaled width
                height: obj.getScaledHeight(), // Get the scaled height
            };
        }
    });
    // const imageWrapper = document.getElementById('imageEditor1');
    // const imgElement = document.getElementById('image');
    // let canvasEL = document.getElementById('imageEditor1')
    // const canvasRect = canvasEL.getBoundingClientRect();

    // const imageWrapperRect = imageWrapper.getBoundingClientRect();
    // const width = imgElement.clientWidth;
    // const height = imgElement.clientHeight;
    // const left = imageWrapperRect.left - canvasRect.left;
    // const top = imageWrapperRect.top - canvasRect.top;
    // const centerX = left + width / 2;
    // const centerY = top + height / 2;

    // var shapeImageData = [];

    // shapeImageData ={
    //     shape: current_shape,
    //     centerX: centerX,
    //     centerY: centerY,
    //     width: width,
    //     height: height,
    // };

    dbJson = {
        textElements: textData,
        shapeImageData : shapeImageData
    };
    console.log(dbJson);

    return dbJson;
}