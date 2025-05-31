// terminal.js
const terminal = document.getElementById("terminal");

const commands = [
  "Initializing TEAM MADS HackTerminal...",
  "Loading tools...",
  "Bypassing security protocols...",
  "Injecting AutoExploit Toolkit...",
  "✓ IP Tracker Ready",
  "✓ Facebook Brute Tool Loaded",
  "✓ Email Spoofer Activated",
  "✓ Telegram Bot Injected",
  "✓ Fake Login Generator ✅",
  "Launching UI Interface...",
  "System Online. Access Granted."
];

let lineIndex = 0;
let charIndex = 0;

function typeLine() {
  if (lineIndex < commands.length) {
    const line = document.createElement("div");
    line.className = "terminal-line";
    terminal.appendChild(line);

    const typingInterval = setInterval(() => {
      if (charIndex < commands[lineIndex].length) {
        line.textContent += commands[lineIndex].charAt(charIndex);
        charIndex++;
      } else {
        clearInterval(typingInterval);
        charIndex = 0;
        lineIndex++;
        setTimeout(typeLine, 500);
      }
    }, 50);
  } else {
    const finalLine = document.createElement("div");
    finalLine.className = "terminal-line";
    finalLine.innerHTML = '<span style="color:#0f0;">root@teammad:~#</span> <span class="cursor"></span>';
    terminal.appendChild(finalLine);
  }
}

typeLine();
