<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirana Store Calculator</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            color: #2c3e50;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            color: #34495e;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            text-align: left;
            font-size: 14px;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #dcdfe3;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        input[type="number"]:focus {
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.4);
            border-color: #3498db;
        }

        button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #2980b9;
        }

        .link {
            margin-top: 15px;
            display: inline-block;
            text-decoration: none;
            color: #3498db;
            font-size: 14px;
        }

        .link:hover {
            text-decoration: underline;
        }

        .result {
            margin-top: 20px;
            padding: 20px;
            background: #f4f6f9;
            border: 1px solid #e0e4e8;
            border-radius: 8px;
            text-align: left;
        }

        .result h2 {
            color: #27ae60;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 15px;
        }

        .toggle-buttons {
            margin-bottom: 20px;
        }

        .toggle-buttons button {
            margin: 0 10px;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            background: #ecf0f1;
            color: #2c3e50;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle-buttons button.active {
            background: #3498db;
            color: #fff;
        }

        .toggle-buttons button:hover {
            background: #bdc3c7;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kirana Store Calculator</h1>
        <div class="toggle-buttons">
            <button id="priceButton" class="active" onclick="showCalculator('price')">Price Calculator</button>
            <button id="weightButton" onclick="showCalculator('weight')">Weight Calculator</button>
        </div>

        <div id="priceCalculator" style="display: block;">
            <form method="POST" action="">
                <label for="price_per_kg">Price of 1kg (in ₹):</label>
                <input type="number" id="price_per_kg" name="price_per_kg" step="0.01" required>
                
                <label for="quantity_grams">Quantity required (in grams):</label>
                <input type="number" id="quantity_grams" name="quantity_grams" required>
                
                <button type="submit" name="calculate_price">Calculate Price</button>
            </form>
        </div>

        <div id="weightCalculator" style="display: none;">
            <form method="POST" action="">
                <label for="price_per_kg_weight">Price of 1kg (in ₹):</label>
                <input type="number" id="price_per_kg_weight" name="price_per_kg_weight" step="0.01" required>
                
                <label for="money_given">Money given by customer (in ₹):</label>
                <input type="number" id="money_given" name="money_given" required>
                
                <button type="submit" name="calculate_weight">Calculate Weight</button>
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['calculate_price'])) {
                $pricePerKg = $_POST['price_per_kg'];
                $quantityGrams = $_POST['quantity_grams'];
                
                if ($pricePerKg <= 0 || $quantityGrams <= 0) {
                    echo "<p class='error'>Please enter valid positive numbers for both fields.</p>";
                } else {
                    $pricePerGram = $pricePerKg / 1000;
                    $totalPrice = $pricePerGram * $quantityGrams;

                    echo "<div class='result'>";
                    echo "<h2>Calculation:</h2>";
                    echo "<p><strong>Price per 1kg:</strong> ₹{$pricePerKg}</p>";
                    echo "<p><strong>Quantity required:</strong> {$quantityGrams} grams</p>";
                    echo "<p><strong>Total price:</strong> ₹" . number_format($totalPrice, 2) . "</p>";
                    echo "</div>";
                }
            }

            if (isset($_POST['calculate_weight'])) {
                $pricePerKg = $_POST['price_per_kg_weight'];
                $moneyGiven = $_POST['money_given'];
                
                if ($pricePerKg <= 0 || $moneyGiven <= 0) {
                    echo "<p class='error'>Please enter valid positive numbers for both fields.</p>";
                } else {
                    $pricePerGram = $pricePerKg / 1000;
                    $weightInGrams = $moneyGiven / $pricePerGram;

                    echo "<div class='result'>";
                    echo "<h2>Calculation:</h2>";
                    echo "<p><strong>Price per 1kg:</strong> ₹{$pricePerKg}</p>";
                    echo "<p><strong>Money given:</strong> ₹{$moneyGiven}</p>";
                    echo "<p><strong>Weight:</strong> " . number_format($weightInGrams, 2) . " grams</p>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>

    <script>
        function showCalculator(type) {
            const priceCalculator = document.getElementById('priceCalculator');
            const weightCalculator = document.getElementById('weightCalculator');
            const priceButton = document.getElementById('priceButton');
            const weightButton = document.getElementById('weightButton');

            if (type === 'price') {
                priceCalculator.style.display = 'block';
                weightCalculator.style.display = 'none';
                priceButton.classList.add('active');
                weightButton.classList.remove('active');
            } else {
                priceCalculator.style.display = 'none';
                weightCalculator.style.display = 'block';
                weightButton.classList.add('active');
                priceButton.classList.remove('active');
            }
        }
    </script>
</body>
</html>
