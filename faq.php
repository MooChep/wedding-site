<?php
$result = $conn->query("SELECT * FROM faq");
while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['question'] . "</h3>";
    echo "<p>" . $row['answer'] . "</p>";
}

?>

<h1> Réponses aux questions :</h1>