# OpenCode JetBrains Plugin

A JetBrains IDE plugin that integrates OpenCode AI assistant directly into your development environment.

## Features

- **Chat Panel**: Interactive chat interface accessible from the IDE tool window
- **OpenCode Server Management**: Automatically launches and manages OpenCode server
- **Real-time Assistance**: Get AI-powered coding help without leaving your IDE
- **Context Awareness**: Works with your current project context

## Requirements

- IntelliJ IDEA 2023.2 or later (Community or Ultimate Edition)
- OpenCode CLI installed and available in your system PATH
- Java 17 or later

## Installation

### Installing OpenCode

Before using this plugin, you need to install OpenCode:

```bash
# Install OpenCode CLI (example - adjust based on actual installation method)
npm install -g opencode
# or
pip install opencode
```

### Installing the Plugin

1. Build the plugin:
   ```bash
   cd opencode-jetbrains-plugin
   ./gradlew buildPlugin
   ```

2. Install in your IDE:
   - Go to `Settings/Preferences` → `Plugins` → `⚙️` → `Install Plugin from Disk...`
   - Select the generated ZIP file from `build/distributions/`
   - Restart your IDE

## Usage

1. Open any project in your JetBrains IDE
2. Look for the "OpenCode Chat" tool window on the right side panel
3. Click on it to open the chat interface
4. Type your questions or requests and press `Ctrl+Enter` or click "Send"
5. The OpenCode AI assistant will respond to your queries

### Keyboard Shortcuts

- `Ctrl+Enter` - Send message in chat

### Actions

- **Clear Chat** - Clear the chat history
- **Restart Server** - Restart the OpenCode server if it becomes unresponsive

## Building from Source

```bash
# Clone the repository
git clone <repository-url>
cd opencode-jetbrains-plugin

# Build the plugin
./gradlew buildPlugin

# Run in a sandboxed IDE instance for testing
./gradlew runIde
```

## Development

The plugin is built using:
- Kotlin 1.9.21
- IntelliJ Platform SDK 2023.2
- Gradle 8.5+

### Project Structure

```
src/main/
├── kotlin/com/opencode/plugin/
│   ├── actions/          # Plugin actions (clear chat, restart server)
│   ├── listeners/        # Application lifecycle listeners
│   ├── models/           # Data models (ChatMessage)
│   ├── services/         # Business logic services
│   │   ├── OpenCodeServerService.kt
│   │   └── OpenCodeProjectService.kt
│   └── ui/              # User interface components
│       ├── OpenCodeChatPanel.kt
│       └── OpenCodeToolWindowFactory.kt
└── resources/
    ├── META-INF/
    │   └── plugin.xml   # Plugin configuration
    └── icons/
        └── opencode.svg # Plugin icon
```

## Configuration

The plugin uses default settings:
- Server Port: 3000
- Server Command: `opencode serve --port 3000`

These can be modified in the `OpenCodeServerService.kt` file.

## Troubleshooting

### Server Not Starting

If you see "OpenCode server is not running":
1. Ensure OpenCode is installed: `which opencode` or `where opencode`
2. Check if the port 3000 is available
3. Try restarting the server using the "Restart Server" action

### Connection Issues

If the chat doesn't respond:
1. Check the IDE logs: `Help` → `Show Log`
2. Verify OpenCode server is accessible: `curl http://localhost:3000/health`
3. Restart the server from the plugin actions

## License

[Add your license here]

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues and questions:
- Open an issue on GitHub
- Check the OpenCode documentation at https://opencode.ai
