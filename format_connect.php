<!DOCTYPE html>
<html lang="en">
<head>
    <title>TaskBird</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-variant: small-caps;
        }

        .header {
            position: relative;
            width: 100%;
            height: 80px;
            background-color:#DCD0FF ; /*DCD0FF */
            display: flex; /* Added to align items vertically */
            justify-content: space-between; /* Added to create space between logo and mode */
            align-items: center; /* Center items vertically */
        }

        .mode {
            margin-top: 2%;
            margin-left: 90%;
            margin-bottom: -5%;
        }

        .mode button:hover {
            color: white;
            background-color: #DCD0FF;
        }
 
        .mode button {
            margin-top: 2%;
            text-decoration: none;
            color: black;
            padding: 10px;
            background-color:#ffc800;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: none;
            outline: none;
        }
        .date {
            position: absolute;
            left: 200px;
            font-size: 25px;
            margin-top: 2%;
            margin-bottom:-2%;
            color:black;
        }
        .nav {
            position: absolute;
            top: 80px;
            left: 0;
            height: 90%;
            width: 200px;
            background-color: rgb(194, 194, 194);
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;

        }
        .nav a {
            text-decoration: none;
            color: black;
            padding: 10px;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 5px;
            text-align: center;
            line-height: 50px;
        }
        .pages {
            border-color: black;
        }

        .main {
            margin-left: 200px; /* Adjusted the margin to accommodate the width of the nav bar */
            margin-right: 0; /* Removed right margin */
            width: calc(100% - 200px); /* Adjusted the width to fill the remaining space */
            height: calc(100% - 80px);
            background-color: white;
            text-align: center;
            color: black;
        }

        .main h1 {
            margin: 0;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        .weather {
            background-color: skyblue;
            position: absolute;
            left: 50px;
            top: 150px;
            width: 300px;
            height: 300px;
            text-align: left;
            
        }

        .today {
            border: 2px solid;
            border-color: black;
            position: absolute;
            left: 400px;
            width: 450px;
            height: 550px;
            text-align: left;
        }
        .stg {
            border: 2px solid;
            border-color: black;
            position: absolute;
            left: 900px;
            width: 300px;
            height: 250px;
            text-align: left;
        }
        .ltg {
            border: 2px solid;
            border-color: black;
            position: absolute;
            left: 900px;
            top: 400px;
            width: 300px;
            height: 250px;
            text-align: left;
        }
        
    .profile-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust the minimum and maximum width as needed */
        gap: 20px; /* Adjust the gap between profiles */
        justify-content: center;
        margin-top: -3%;
        margin-left: 1.5%;
    }
    .profile {
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    padding: 10px;
    text-align: center;
    margin: 10px;
    background-color: #ff990062;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    flex-grow: 1;
}

.profile img {
    max-width: 100%;
    object-fit: cover;
    height: 40%;
}

.profile-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

        /* Add styling for the filter bar */
        .filterBar {
            display: flex;
            justify-content:flex-start;
            align-items: center;
            margin-top: -2%;
            margin-bottom: 2%;
            padding: 10px;
            background-color: #f0f0f0;
        }

        .filter-input {
            width: 80%;
            margin-left: 1.5%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-button {
            padding: 10px;
            margin-left: 2%;
            background-color:#4CAF50;
            color:white;
            font-weight: bolder;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: large;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .filter-button:hover {
            background-color: #409044;
        }

        #noProfilesMessage {
            display: none; 
            color:#d1a400; 
            margin-top: 10px;
            font-weight: 700;
        }

        .button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        }

        .button:hover {
        background-color: #555;
        }

        /* Add this to your existing CSS */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 400px;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

#priceValue {
    display: inline-block;
    margin-left: 10px;
}


.sidebar {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #DCD0FF;
  overflow-x: hidden;
  padding-top: 16px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #000000;
  display: block;
}

.sidebar a:hover {
  color: #ffd036;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}

    </style>
</head>
<body>
    <?php
/*
echo "<div class='header'>";
echo "<a class='logo' href='home.html'><img style='width:100px; height: 100%; margin-left: 5px;'  src='TaskBird.png' id='logo' ></img></a>";
echo "<div class ='date' id='date'></div>";
echo "<div class='mode'>";
echo "<button type='button' id='mode' onclick='changeColor_conn()'>Light Mode</button>";
echo  "</div>";
echo "</div>";
*/

    
echo "<div class='sidebar'>";
    echo "<a class='logo' href='home.html'><img style='width:100px; height: 100%; margin-left: 5px; margin-top:-2%; margin-bottom: 3%'  src='TaskBird.png' id='logo' ></img></a>";
    echo "<a href='https://felixzsong8.github.io/TaskBird/home.html'><i class='fa fa-fw fa-home'></i>Home</a>";
    echo "<a href='https://felixzsong8.github.io/TaskBird/calendar.html'><i class='fa fa-fw fa-calendar'></i> Calendar</a>";
    echo "<a href='https://felixzsong8.github.io/TaskBird/checklist.html'><i class='fa fa-fw fa-check-square-o'></i>CheckList</a>";
    echo "<a href='https://yvonnel.sgedu.site/final_proj/connect_catfilt.php'><i class='fa fa-fw fa-user'></i> <strong>Connect</strong></a>";

echo "</div>";

echo "<div class ='date' id='date'></div>";
echo "<span class='mode'>";
echo "<button type='button' id='mode' onclick='changeColor_conn()'>Light Mode</button>";
echo  "</span>";

echo "<div class='main' id='main'>";
echo "<h1 style='margin-bottom: -4%'>Connect</h1>";
echo "<h4 style='margin-bottom: 5%; margin-top: -2%; font-variant: normal; font-weight: normal;'> Discover and connect with professionals showcasing a diverse range of skills. <br>Whether you're seeking expertise or looking to share your skills, connect with individuals with skillsets tailored to fit your needs.</h3>";
/*
echo "<div class='nav'>";
echo "<div class='pages'>";
            echo "<a href='https://felixzsong8.github.io/TaskBird/home.html'><strong>Home</strong></a><br>";
            echo "<a href='https://felixzsong8.github.io/TaskBird/calendar.html'>Calendar</a><br>";
            echo "<a href='https://felixzsong8.github.io/TaskBird/checklist.html'>CheckList</a><br>";
            echo "<a href='https://felixzsong8.github.io/TaskBird/entertainment.html'>Entertainment</a><br>";
            echo "<a href='https://yvonnel.sgedu.site/final_proj/connect_catfilt.php'>Connect</a>";
            echo "</div>";
            echo "</div>";
            echo "<div class='main' id='main'>";
            echo "<h1 style='margin-bottom: -4%'>Connect</h1>";
            echo "<h4 style='margin-bottom: 5%; margin-top: -2%; font-variant: normal; font-weight: normal;'> Discover and connect with professionals showcasing a diverse range of skills. <br>Whether you're seeking expertise or looking to share your skills, connect with individuals with skillsets tailored to fit your needs.</h3>";
            */
            
            //////////////////////////////////////////////////////
            
            // Establish connection info
            $server = "localhost";// your server
    $userid = "unferpmd3gfuu"; // your user id
    $pw = "{l#.*4k41i$6"; // your pw
    $db = "dbpstnpkyh0pjq"; // your database

    // Create connection
    $conn = new mysqli($server, $userid, $pw);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Select the database
    $conn->select_db($db);

    // Run a query to fetch profiles and their associated categories
    $sql = "SELECT p.imageName, p.firstName, p.lastName, p.profileDescription, p.skills, GROUP_CONCAT(c.category_id SEPARATOR ', ') AS categories
            FROM profiles p
            LEFT JOIN profile_categories pc ON p.profile_id = pc.profile_id
            LEFT JOIN categories c ON pc.category_id = c.category_id
            GROUP BY p.profile_id";
    $result = $conn->query($sql);

    echo "<div class='filterBar'>";
    echo "<input type='text' class='filter-input' id='filterInput' placeholder='Search profiles...'>";
    echo "<button class='filter-button' onclick='filterProfiles()'>Search Profiles</button>";
    echo "</div>";

    // Fetch categories from the database
    $categoriesResult = $conn->query("SELECT * FROM categories");
    if ($categoriesResult->num_rows > 0) {
        echo "<span style='margin-top:-2%'>";
        while ($category = $categoriesResult->fetch_assoc()) {
            echo "<label><input type='checkbox' class='category-checkbox' value='" . $category['category_id'] . "'> " . $category['category_name'] . "</label>";
        }
        echo "</span>";
    }

    echo "<div class='profile-container' style='margin-top: 2%'>";

    // Loop through each profile and display data
    while ($row = $result->fetch_assoc()) {
        echo "<div class='profile'>";
            echo "<img src='{$row['imageName']}' alt='{$row['firstName']} {$row['lastName']}'>";
        echo "<span class='profile-content'>";
        echo "<h3>{$row['firstName']} {$row['lastName']}</h3>";
        echo "<span style='margin-top: -3%'>" . $row['profileDescription'] . "</span>";
        echo "<span style='margin-bottom: 2%'><b>Skills</b>: " . $row['skills'] . "</span>";
        echo "</span>";
        echo "<button class='button' onclick='openModal(\"" . $row['firstName'] . " " . $row['lastName'] . "\")'>Contact</button>";
    
        // Store categories in a data attribute without displaying them
        echo "<div data-categories='{$row['categories']}'></div>";
        
        //echo "</div>";
        echo "</div>";
    }
    
    echo "</div>";
    
    // Close the connection
    $conn->close();
    ?>
            
          <!-- Repeat this structure for additional profiles -->
          <div id='noProfilesMessage'>
            No profiles found. Please try using another keyword.
        </div>
          </div>
    </div>
    <script>
        //Script to work for the weather
        /*
        */
        var currentDate = new Date();
        dateContainer = document.getElementById("date");
        days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']
        day = days[currentDate.getDay()];
        dateContainer.innerHTML = day + ", " + currentDate.getMonth() + "/" + currentDate.getDate() + "/" + currentDate.getFullYear();

        //Lightmode
        var colorMode = document.getElementById("mode")
        var main = document.getElementById("main");
        var filterBar = document.querySelector('.filterBar');
        var noResultsMsg = document.getElementById("noProfilesMessage");
        var profile = document.getElementsByClassName('profile');
        var date = document.getElementById("date");

        main.style.backgroundColor = "white";
        colorMode.innerHTML = "Light Mode"
        function changeColor_conn() {
            if(main.style.backgroundColor == "white"){
                main.style.backgroundColor = "black";
                main.style.color = "white";
                filterBar.style.backgroundColor = "black";
                noResultsMsg.style.color = "#ffc800";
                colorMode.innerHTML = "Dark Mode";
                document.body.style.backgroundColor = "black";
                
                date.style.color = "#ffd036";
                // Change background color of profiles
                /*
                for (var i = 0; i < profile.length; i++) {
                    profile[i].style.backgroundColor = "#fad96de4";
                }
                */
               
            }else{
                main.style.backgroundColor = "white";
                main.style.color = "black"; // Change text color to white
                filterBar.style.backgroundColor = "#f0f0f0";
                noResultsMsg.style.color = "#d1a400";
                colorMode.innerHTML = "Light Mode"
                document.body.style.backgroundColor = "white";
                
                date.style.color = "black";

                // Change background color of profiles
                for (var i = 0; i < profile.length; i++) {
                    profile[i].style.backgroundColor = "#ff990062";
                }
            }
        }

           // Event listener for category checkboxes
    var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    categoryCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function() {
            console.log('Checkbox changed. Category ID:', checkbox.value);
    });
});


// FilterProfiles function to handle filtering
function filterProfiles() {
    var input = document.getElementById('filterInput').value.toLowerCase();
    var profiles = document.getElementsByClassName('profile');
    var noProfilesMessage = document.getElementById('noProfilesMessage');

    var foundProfiles = false; // Variable to track if any profiles are found

    // Split the input into individual words
    var searchWords = input.split(' ');

    for (var i = 0; i < profiles.length; i++) {
        var profileText = profiles[i].textContent.toLowerCase();

        // Check if any of the search words are present in the profile text
        var textMatch = searchWords.some(function (word) {
            return profileText.includes(word);
        });

        // Check if the profile has any of the selected categories
        var categoryMatch = Array.from(categoryCheckboxes).some(function (checkbox) {
            if (checkbox.checked) {
                var categoryId = checkbox.value;
                console.log("categoryId from checkbox value (checking for match): " + categoryId)
                var categories = profiles[i].querySelector('[data-categories]').getAttribute('data-categories');
                console.log('Profile:', profiles[i].textContent);
                console.log('Categories:', categories);
                return categories.includes(categoryId);
            }
            return false;
        });

        // Toggle the display of profiles based on the search and category filters
        if ((input === '' || textMatch) && (categoryMatch || noSelectedCategories())) {
            profiles[i].style.display = '';
            foundProfiles = true;
        } else {
            profiles[i].style.display = 'none';
        }
    }

    // Toggle the visibility of the "no profiles found" message based on the results
    noProfilesMessage.style.display = foundProfiles ? 'none' : 'block';
}

// Function to check if no categories are selected
function noSelectedCategories() {
    return !Array.from(categoryCheckboxes).some(function (checkbox) {
        return checkbox.checked;
    });
}


function openModal(recipient) {
    var modal = document.getElementById("messageModal");
    var recipientInput = document.getElementById("recipient");
    var priceRangeInput = document.getElementById("priceRange");
    var priceValueSpan = document.getElementById("priceValue");

    modal.style.display = "flex";
    recipientInput.value = recipient;

    // Update price value dynamically
    priceRangeInput.addEventListener("input", function () {
        priceValueSpan.textContent = priceRangeInput.value;
    });
}

function closeModal() {
    document.getElementById("messageModal").style.display = "none";
}

function sendMessage() {
    var emailInput = document.getElementById("email").value;

    // Check if the email field is empty
    if (!emailInput.trim()) {
        alert("Please provide your email address.");
        return; // Do not proceed with sending the message
    }

    // Handle the logic for sending the message here
    closeModal();
    alert("Message sent!");
}

var messageModal = document.getElementById("messageModal");

// Close the modal if the user clicks outside of it
window.addEventListener("click", function(event) {
    if (event.target === messageModal) {
        closeModal();
    }
});

// Prevent the modal from closing if the click event originates from within the modal
messageModal.addEventListener("click", function(event) {
    event.stopPropagation();
});
    </script>

<div id="messageModal" class="modal">
    <div class="modal-content" style='background-color:#dcd0ffe0;'>
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id='modal_title' style='margin-top: -2%'>Send Message</h2>
        <form id="messageForm">
            <label for="recipient">Recipient:</label>
            <input type="text" id="recipient" name="recipient" readonly>
            <br></br>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            <br></br>
            <label for="priceRange">Price Range:</label>
            <input type="range" id="priceRange" name="priceRange" min="$1" max="$1000" value="50">
            <span id="priceValue">$50</span>
            <br></br>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            <br></br>
            <button type="button" onclick="sendMessage()">Send Message</button>
        </form>
    </div>
</div>

</body>
</html>