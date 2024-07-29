document.addEventListener('DOMContentLoaded', function () {
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const sendButton = document.querySelector('#chatbot button');

    function appendMessage(message, isUser = true) {
        const messageElement = document.createElement('div');
        messageElement.className = isUser ? 'message user' : 'message bot';
        messageElement.textContent = message;
        chatbotMessages.appendChild(messageElement);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight; // Auto-scroll to the latest message
    }

    sendButton.addEventListener('click', function () {
        const message = chatbotInput.value;
        if (message.trim()) {
            appendMessage(message);
            chatbotInput.value = '';

            // Send the message to chatbot_response.php
            fetch('chatbot_response.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                appendMessage(data.response, false); // Add bot response
            })
            .catch(error => {
                console.error('Error:', error);
                appendMessage('Sorry, there was an error processing your request.', false);
            });
        }
    });

    chatbotInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendButton.click();
        }
    });
});
