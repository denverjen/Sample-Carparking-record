<?php
// dbconfig.php
include_once('dbconfig.php') ;

function createTable($con, $sql) {
    if (mysqli_query($con, $sql)) {
        return "Table created successfully";
    } else {
        return "Error creating table: " . mysqli_error($con);
    }
}

function insertData($con, $sql) {
    if (mysqli_query($con, $sql)) {
        return "Data inserted successfully";
    } else {
        return "Error inserting data: " . mysqli_error($con);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = mysqli_connect($dbhost, $dbuser , $dbpassword, $dbname);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $tables = [
        "admins" => "CREATE TABLE IF NOT EXISTS admins (
            id int NOT NULL AUTO_INCREMENT,
            auser varchar(255) NOT NULL,
            apassword varchar(255) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY auser_index (auser)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "carparking" => "CREATE TABLE IF NOT EXISTS carparking (
            id int NOT NULL AUTO_INCREMENT,
            carno varchar(50) NOT NULL,
            cartype varchar(50) NOT NULL,
            time_in datetime DEFAULT NULL,
            time_out datetime DEFAULT NULL,
            code varchar(50) DEFAULT NULL,
            blk varchar(50) DEFAULT NULL,
            room varchar(50) DEFAULT NULL,
            parking int DEFAULT '1',
            overtime int DEFAULT NULL,
            cphone varchar(50) DEFAULT NULL,
            PRIMARY KEY (id),
            KEY park_index (parking, id)
        ) ENGINE=InnoDB AUTO_INCREMENT=2405 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "cartype" => "CREATE TABLE IF NOT EXISTS cartype (
            id int NOT NULL AUTO_INCREMENT,
            cartypes varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "codes" => "CREATE TABLE IF NOT EXISTS codes (
            id int NOT NULL AUTO_INCREMENT,
            codename varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "users" => "CREATE TABLE IF NOT EXISTS users (
            id int NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY name_index (name)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci"
    ];

    $data = [
        "admins" => "INSERT INTO admins (auser, apassword) VALUES ('admin', '12345678')",
        "cartype" => "INSERT INTO cartype (cartypes) VALUES ('私家車'), ('小型貨車'), ('大型貨車'), ('電單車'), ('緊急車輛'), ('康復接送')",
        "codes" => "INSERT INTO codes (codename) VALUES ('送貨'), ('外賣'), ('接送/訪客'), ('工程車輛'), ('搬屋'), ('紅白事')",
        "users" => "INSERT INTO users (name, password) VALUES ('user', '123456')"
    ];

    $table = $_POST['table'];
    if (isset($tables[$table])) {
        echo createTable($con, $tables[$table]);
        if (isset($data[$table])) {
            echo insertData($con, $data[$table]);
        }
    }

    mysqli_close($con);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Database Tables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .progress {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Install Database Tables</h1>
    <div id="progress" class="progress"></div>
    <button onclick="installTables()">Start Installation</button>

    <script>
        function installTables() {
            const tables = ["admins", "carparking", "cartype", "codes", "users"];
            let progressDiv = document.getElementById('progress');
            progressDiv.innerHTML = '';

            tables.forEach((table, index) => {
                setTimeout(() => {
                    fetch('dbinstall.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `table=${encodeURIComponent(table)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        progressDiv.innerHTML += `<p>Table ${table}: ${data}</p>`;
                        if (index === tables.length - 1) {
                            progressDiv.innerHTML += '<p>Installation complete!</p>';
                        }
                    })
                    .catch(error => {
                        progressDiv.innerHTML += `<p>Error installing table ${table}: ${error}</p>`;
                    });
                }, index * 2000); // Delay each installation by 2 seconds
            });
        }
    </script>
</body>
</html>
