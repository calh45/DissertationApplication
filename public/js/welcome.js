var currentIndex = 0; //Index of currently displayed image
var imageSources = ["images/homePage/1.png", "images/homePage/2.png", "images/homePage/3.png", "images/homePage/4.png",
                    "images/homePage/5.png", "images/homePage/6.png"]; //Images to be looped through

/**
 * Function to loop through display images for home screen View every 3 seconds
 */
setInterval(function slider(){
    //If current index is outside of number of images, reset to 0
    if(currentIndex === imageSources.length){
        currentIndex = 0;
    }

    //Change image displayed and increment index
    document.getElementById("changePanel").src = imageSources[currentIndex];
    currentIndex ++;

},3000);
