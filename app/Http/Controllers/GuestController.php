<?php

namespace App\Http\Controllers;

use App\Models\FreeQuote;
use Exception;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function freequote(Request $request)
    {
        $validate = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'message' => 'string|max:255'
        ]);

        $freequote = FreeQuote::create($validate);

        return redirect()->route('/');
    }

    public function apiRequest()
    {
        return view('submitButton');
    }

    public function realApiRequest(Request $request)
    {
        set_time_limit(180); // sets the maximum execution time to 2 minutes

        $subject = "Biology";
        $topic = "Digestive System";
        $age = 15;
        $curriculum = "Spanish Curriculum";


        $concept = [];
        // In Traditional Spanish from Spain. 
        try {

            $prompt = "En español tradicional de España. Eres un experto en explicar conceptos profundos de manera concisa y efectiva a estudiantes de " . $age . " años. Proporciona una explicación breve del concepto para un estudiante que estudia '$topic' en la asignatura '$subject' y que sigue el plan de estudios '$curriculum'. Explica cada concepto utilizando un lenguaje sencillo y ejemplos para que sea fácilmente comprensible para el estudiante. Encierra cada encabezado en [h] [/h]. Asegúrate de que la explicación cubra todos los aspectos esenciales del tema. Incluye un ejemplo del concepto al final. Cada encabezado debe comenzar en una nueva línea. Evita la práctica de indicar 'Contenido: Este es el contenido', es decir, no es necesario agregar una etiqueta y dos puntos al contenido.";

            $assistantPrompt = "Eres un experto en explicar conceptos profundos de manera concisa y efectiva a estudiantes de " . $age . " años. Mantén los ejemplos concisos.";
            $data = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => $assistantPrompt
                    ],
                    [
                        "role" => "user",
                        "content" => $prompt
                    ],
                ],
                'temperature' => 0.9,
                'max_tokens' => 500,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ];

            $json_data = json_encode($data);

            $ch = curl_init('https://api.openai.com/v1/chat/completions');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . getenv('OPENAI_API_KEY'),
                'Content-Length: ' . strlen($json_data)
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120); // 120 seconds is 2 minutes


            $result = curl_exec($ch);
            $completeDecoded = json_decode($result);

            if (curl_errno($ch)) {
                throw new Exception(curl_error($ch));
            }

            curl_close($ch);

            $concept = $completeDecoded->choices[0]->message->content;
            $concept = str_replace('[h]', '<h2>', $concept);
            $concept = str_replace('[/h]', '</h2>', $concept);

            dd($concept);

            // dd($concept);
        } catch (Exception $e) {
            // Handle exceptions thrown by the OpenAI PHP SDK or custom exceptions
            // Log the error message or display an appropriate error message to the user
            error_log("Error: " . $e->getMessage());
        }

        // Store the lesson data in the session and redirect to the showLessonPlanner method
        $request->session()->put('concept', $concept);
        $request->session()->put('curriculum', $curriculum);
        $request->session()->put('topic', $topic);
        $request->session()->put('subject', $subject);
        $request->session()->put('age', $age);

        // Store the generated content in the histories table
        $user_id = auth()->id(); // Get the authenticated user's ID
        $tool_name = 'Concept Explainer';
        $content = json_encode($concept); // Convert the lesson array to a JSON string

        // $history = new History([
        //     'user_id' => $user_id,
        //     'tool_name' => $tool_name,
        //     'content' => $content,
        // ]);

        // $history->save();

        return redirect()->action([ToolController::class, 'showConceptExplainer']);
    }
}
