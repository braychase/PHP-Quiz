<?php
    session_start();

    $quiz = $_SESSION['full_quiz'];

    if (!isset($_SESSION['currentQuestionNumber'])) {
        $_SESSION['currentQuestionNumber'] = 0;
    }

    $numberOfQuestions = count($quiz['questions']);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $action = $_POST["action"];
        $currentQuestionNumber = $_SESSION['currentQuestionNumber'];
    
        //check if a new answer is selected in the current question
        if (isset($_POST["answer"])) {
            $selectedAnswer = $_POST["answer"];
            $_SESSION['user_answers'][$currentQuestionNumber] = $selectedAnswer;
        }

        //update the current question number
        if ($action === "next" && $currentQuestionNumber < $numberOfQuestions - 1) {
            //move to the next question if not on the last question
            $currentQuestionNumber++;
        } elseif ($action === "previous" && $currentQuestionNumber > 0) {
            //move to the previous question if not on the first question
            $currentQuestionNumber--;
        } elseif ($action === "done") {
            //check if all questions have been answered
            $userAnswers = $_SESSION['user_answers'];
            $allQuestionsAnswered = !in_array(-1, $userAnswers, true);

            if ($allQuestionsAnswered) {
                header("Location: results.php");
                exit();
            } else {
                //if not all questions are answered, redirect to error.php
                header("Location: error.php");
                exit();
            }
        }

        $_SESSION['currentQuestionNumber'] = $currentQuestionNumber;
    }

    //get current question number and user answers from session
    $currentQuestionNumber = $_SESSION['currentQuestionNumber'];
    $userAnswers = $_SESSION['user_answers'];

    $question = $quiz['questions'][$currentQuestionNumber];
    $questionText = $question['questionText'];
    $choices = $question['choices'];

    //booleans for enabling or disabling buttons
    $isFirstQuestion = ($currentQuestionNumber === 0);
    $isLastQuestion = ($currentQuestionNumber === ($numberOfQuestions - 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Question</title>
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
        :disabled {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class='questionContainer'>
        <h1>Question <?php echo ($currentQuestionNumber + 1); ?></h1>
        <p><?php echo $questionText; ?></p>

        <form method="post">
            <?php foreach ($choices as $index => $choice) { ?>
                <label>
                    <input type="radio" name="answer" value="<?php echo $index; ?>"
                        <?php
                        if (isset($_SESSION['user_answers'][$currentQuestionNumber]) &&
                            $_SESSION['user_answers'][$currentQuestionNumber] == $index) {
                            echo 'checked';
                        }
                        ?>
                    >
                    <?php echo $choice; ?>
                </label><br>
            <?php } ?>
    </div>
            <button class='submitButton' type="submit" name="action" value="previous" <?php echo ($isFirstQuestion ? 'disabled' : ''); ?>>Previous</button>
            <button class='submitButton' type="submit" name="action" value="next" <?php echo ($isLastQuestion ? 'disabled' : ''); ?>>Next</button>
            <button class='submitButton' type="submit" name="action" value="done" <?php echo ($isLastQuestion ? '' : 'disabled'); ?>>Done</button>
        </form>
    </body>
</html>