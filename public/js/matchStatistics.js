// Update the count down every 1 second
var minute = 0; //Current minute of match
var second = 0; //Current second of minute
var firstHalfStarted = false; //Has first half begun
var secondHalfStarted = false; //Has second half begun

/**
 * Function to start match timer and display to View
 */
function startTimer() {
    //If first half has not started, begin first half
    if(firstHalfStarted === false) {
        //Update variable
        firstHalfStarted = true;

        //Change timer display in View
        document.getElementById("timerButton").style.display = "none";
        document.getElementById("homeScore").innerHTML = "0";
        document.getElementById("awayScore").innerHTML = "0";

        //Begin counting to 45 minutes
        var x = setInterval(function() {
            //Increment second variable
            second = second + 1;

            //If second is 60 then increment minute variable
            if (second > 60) {
                minute = minute + 1;
                second = 0;
            }

            //If minute has reached 45, stop timer and send to added time
            if (minute === 45) {
                document.getElementById("timer").innerHTML = "45+";
                document.getElementById("timerButton").style.display = "block";
                clearInterval(x);

            }

            //Display current time in view
            document.getElementById("timer").innerHTML = minute + ":" + second;
        }, 1000);
    } else {
        //Update second half start tracker variable
        secondHalfStarted = true;
        document.getElementById("timerButton").style.display = "none";

        //Begin second half timer
        var y = setInterval(function() {
            //Increment second variable
            second = second + 1;

            //If second incremented to over a minute, update minute variable
            if (second > 60) {
                minute = minute + 1;
                second = 0;
            }

            //If minute reaches 90, send to added time
            if (minute > 90) {
                document.getElementById("timer").innerHTML = "90+";
                clearInterval(y);

            }

            //Display current time in View
            document.getElementById("timer").innerHTML = minute + ":" + second;
        }, 1000);


    }
}
