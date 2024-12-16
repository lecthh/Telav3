import './bootstrap';

// Import Zego SDK
import ZegoExpressEngine from 'zego-express-engine-webrtc';

// Initialize Zego SDK
const appID = 'YOUR_APP_ID'; // Replace with your App ID
const appSign = 'YOUR_APP_SIGN'; // Replace with your App Sign
const zegoEngine = ZegoExpressEngine.create(appID, appSign);

// Login to the chat room
const roomID = 'YOUR_ROOM_ID'; // Replace with your room ID
const userID = 'YOUR_USER_ID'; // Replace with your user ID
const userName = 'YOUR_USER_NAME'; // Replace with your user name

zegoEngine.loginRoom(roomID, userID, userName)
    .then(() => {
        console.log('Login successful');
    })
    .catch((error) => {
        console.error('Login failed:', error);
    });

// Send a message
function sendMessage(message) {
    zegoEngine.sendBroadcastMessage(roomID, message)
        .then(() => {
            console.log('Message sent:', message);
        })
        .catch((error) => {
            console.error('Send message failed:', error);
        });
}

// Receive messages
zegoEngine.onReceiveBroadcastMessage = (roomID, message, user) => {
    console.log(`Received message from ${user.userID}: ${message}`);
    // Update your UI with the new message
};

// Example usage
sendMessage('Hello, world!');