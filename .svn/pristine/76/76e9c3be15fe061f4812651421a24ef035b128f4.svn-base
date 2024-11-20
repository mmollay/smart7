<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background-color: #F5D04C;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .settings-container {
            width: 400px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .settings-container h2 {
            color: #4F311E;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .settings-container .ui.form .field input {
            padding: 12px;
        }

        .settings-container .ui.form .field.button {
            margin-top: 30px;
        }

        .settings-container .ui.form .field.button .ui.button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <h2>Einstellungen</h2>
        <form class="ui form" method="POST" action="setting_save.php">
            <div class="field">
                <label>Alter</label>
                <input type="number" name="age" min="1" required>
            </div>
            <div class="field">
                <label>Geschlecht</label>
                <select name="gender" required>
                    <option value="m">Männlich</option>
                    <option value="f">Weiblich</option>
                    <option value="other">Andere</option>
                </select>
            </div>
            <div class="field">
                <label>Größe</label>
                <input type="number" name="height" min="1" required>
            </div>
            <div class="field">
                <label>Gewicht</label>
                <input type="number" name="weight" min="1" required>
            </div>
            <div class="field button">
                <button class="ui primary button" type="submit">Speichern</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
</body>
</html>
