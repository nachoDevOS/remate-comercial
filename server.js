const fs = require("fs");

// const server = require('https').createServer({
//   key: fs.readFileSync("/etc/letsencrypt/live/rematecomercial-server.soluciondigital.dev/privkey.pem"),
//   cert: fs.readFileSync("/etc/letsencrypt/live/rematecomercial-server.soluciondigital.dev/fullchain.pem")
// });

const server = require('http').createServer();

const io = require('socket.io')(server, {
    cors: { origin: "*"}
});


io.on('connection', (socket) => {
    console.log('connection');

    socket.on('pull', data => {
        io.emit(`get_pull`, data);
    });

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

server.listen(3003, () => {
    console.log('Server Socket.io is running');
});