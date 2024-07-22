<?php
$api_key = 'sk-proj-cTquv9jcFP3ndH1eCKhXT3BlbkFJzgZPFKyYPNhfreygTPHi'; // Replace this with your actual OpenAI API key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';

    if (!empty($question)) {
        $data = array(
            'model' => 'text-davinci-003',
            'prompt' => $question,
            'max_tokens' => 50,
            'temperature' => 0.5,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        ));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            $decoded_response = json_decode($response, true);
            $answer = trim($decoded_response['choices'][0]['text'] ?? 'No response');
            echo json_encode(array('answer' => $answer));
        }
        curl_close($ch);
    } else {
        echo "No question provided.";
    }
} else {
    echo "Invalid request method.";
}
?>
