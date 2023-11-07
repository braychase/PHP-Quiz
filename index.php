<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
</head>
<body>
    <h1>Quiz App</h1>
    <p>Select a quiz and press Start to begin:</p>

    <form method="POST" action="buildQuiz.php">
        <select id="fruits" name="quizName">
            <option value="GameOfThronesQuiz.json">Game of Thrones</option>
            <option value="Hockey.json">Hockey</option>
            <option value="JavascriptQuiz.json">Javascript</option>
            <option value="WorldGeography1.json">Wolrd Geography</option>
        </select>
        <button type="submit">Start</button>
    </form>
</body>
</html>
