<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WSP ChatBot</title>
  
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <style>
    #aiButton {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 14px 20px;
      border-radius: 50%;
      font-size: 20px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0,0,0,0.3);
      z-index: 1001;
    }

    #chatWindow {
      display: none;
      position: fixed;
      bottom: 100px;
      right: 30px;
      width: 320px;
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    #response {
      margin-top: 10px;
      padding: 10px;
      background: #f9f9f9;
      border-radius: 5px;
      max-height: 200px;
      overflow-y: auto;
    }
  </style>
</head>
<body>

<!-- Floating Chat UI -->
<div id="chatWindow">
  <h5 class="text-center">💬 Assistant</h5>
  <div class="form-group">
    <input type="text" class="form-control" id="userInput" placeholder="Enter your question"/>
  </div>
  <button class="btn btn-success btn-block" onclick="sendMessage()">Ask!</button>
  <div id="response"></div>
</div>

<!-- Floating Button -->
<button id="aiButton">🤖</button>

<script>
  // Toggle Chat Window
  document.getElementById("aiButton").addEventListener("click", () => {
    const chat = document.getElementById("chatWindow");
    chat.style.display = chat.style.display === "none" ? "block" : "none";
  });

  // Send Message to OpenRouter
  async function sendMessage() {
    const input = document.getElementById('userInput').value;
    const responseDiv = document.getElementById('response');
    if (!input) {
      responseDiv.innerHTML = 'Please enter a message.';
      return;
    }
    responseDiv.innerHTML = 'Loading...';

    try {
      const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
        method: 'POST',
        headers: {
          Authorization: 'Bearer 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',
          'HTTP-Referer': 'https://www.sitename.com',
          'X-Title': 'SiteName',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          model: "google/gemma-3-1b-it:free",
          messages: [{ role: 'user', content: input }]
        })
      });

      const data = await response.json();
      const markdown = data.choices?.[0]?.message?.content || 'No response received.';
      responseDiv.innerHTML = marked.parse(markdown);
    } catch (err) {
      responseDiv.innerHTML = 'Error: ' + err.message;
    }
  }
</script>

</body>
</html>
