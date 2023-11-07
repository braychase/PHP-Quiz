<?php
session_start();

$quiz = $_SESSION['full_quiz'];

$userAnswers = $_SESSION['user_answers'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Assignment 1 - Quiz Results</title>
    <style>
        .questionContainer {
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 20px;
        }
        .submitButton {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        ul {
            list-style-type: none;
        }
        .correct {
            background-color: green;
        }
        .incorrect {
            background-color: red;
        }
    </style>
</head>
<body>
    <?php
    $quiz = $_SESSION['full_quiz'];

    include 'ChromePhp.php';

    $title = $quiz["title"];
    $theQuestions = $quiz["questions"];

    echo "<h1>" . $title . " - Quiz Results</h1>";

    $userAnswers = $_SESSION['user_answers'];

    $count = 0;
    $totalQuestions = count($theQuestions);
    $score = 0;
    foreach ($theQuestions as $question) {
        $questionText = $question["questionText"];
        $choices = $question["choices"];
        $correctAnswerIndex = $question["answer"];
        $correctAnswer = $choices[$correctAnswerIndex];
        $userAnswerIndex = $userAnswers[$count];

        echo "<div class='questionContainer'>";
        echo "<h3>Question " . ($count + 1) . "</h3>";
        echo "<p>" . $questionText . "</p>";

        echo "<ul>";
        foreach ($choices as $index => $choice) {
            echo "<li><input type='radio' name='question$count' value='$choice' disabled";
            if ($userAnswerIndex === $index) {
                echo " checked";
            }
            echo ">$choice</li>";
        }
        echo "</ul>";

        if ($userAnswerIndex == $correctAnswerIndex) {
            echo "<p class='correct'>Your answer: " . $choices[$userAnswerIndex] . " (correct)</p><br>";
            $score++;
        } else {
            echo "<p class='incorrect'>Your answer: " . $choices[$userAnswerIndex] . " (incorrect)</p><br>";
            echo "Correct answer: " . $choices[$correctAnswerIndex] . "<br>";
        }

        echo "</div>";
        $count++;
    }
    ?>
    <h2>Score</h2>
    <p>Your score is <?php echo $score; ?> out of <?php echo $totalQuestions; ?></p>
</body>
</html>
