<?php
require_once __DIR__ ."/models/SentimentAnalyzer.php";

// Example reviews
$reviews = [
    "I love this product!",
    "Worst purchase ever.",
    "Good quality and excellent service!",
];

$total_reviews = count($reviews);
$positive_reviews = 0;
$negative_reviews = 0;
$neutral_reviews = 0;

foreach ($reviews as $review) {
    $result = SentimentAnalyzer::analyze($review);
    $pos = $result['positive_count'];
    $neg = $result['negative_count'];

    if ($pos > $neg) {
        $positive_reviews++;
    } elseif ($neg > $pos) {
        $negative_reviews++;
    } else {
        $neutral_reviews++;
    }
}

$data = [
    "total" => 5,
    "positive" => 3,
    "negative" => 1,
    "neutral" => 1
];
echo json_encode($data);


// $data = [
//     "total" => $total_reviews,
//     "positive" => $positive_reviews,
//     "negative" => $negative_reviews,
//     "neutral" => $neutral_reviews
// ];

// echo json_encode($data);
?>
