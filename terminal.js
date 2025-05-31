const input = document.getElementById('commandInput');
const output = document.getElementById('terminalOutput');

const commands = {
  help: "Available commands:\n- help\n- tools\n- contact\n- clear",
  tools: "Redirecting to tools page...",
  contact: "Redirecting to contact page...",
  clear: "",
};

input.addEventListener('keydown', function (e) {
  if (e.key === 'Enter') {
    const cmd = input.value.trim().toLowerCase();
    output.textContent += `\n>> ${cmd}`;

    if (commands[cmd] !== undefined) {
      if (cmd === 'tools') {
        window.location.href = 'tools.html';
      } else if (cmd === 'contact') {
        window.location.href = 'contact.html';
      } else if (cmd === 'clear') {
        output.textContent = '';
      } else {
        output.textContent += `\n${commands[cmd]}`;
      }
    } else {
      output.textContent += `\nUnknown command: ${cmd}`;
    }

    input.value = '';
  }
});
