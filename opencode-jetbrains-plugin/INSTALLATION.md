# OpenCode JetBrains Plugin - Installation & Setup Guide

## Prerequisites

Before you can build and use the OpenCode JetBrains plugin, ensure you have:

1. **Java Development Kit (JDK) 21 or later**
   ```bash
   java -version
   # Should show Java 21 or higher
   ```

2. **Gradle 8.5 or later** (or use the included Gradle wrapper)
   ```bash
   gradle --version
   ```

3. **OpenCode CLI** (the actual OpenCode application)
   ```bash
   # Install OpenCode (adjust based on actual installation method)
   npm install -g opencode
   # or
   pip install opencode
   
   # Verify installation
   which opencode
   ```

4. **IntelliJ IDEA or compatible JetBrains IDE**
   - IntelliJ IDEA 2024.2 or later (Community or Ultimate Edition)
   - Other JetBrains IDEs based on the same platform version

## Building the Plugin

### Step 1: Navigate to the Plugin Directory

```bash
cd opencode-jetbrains-plugin
```

### Step 2: Build the Plugin

Using Gradle wrapper (recommended):
```bash
./gradlew buildPlugin
```

Or using your system Gradle:
```bash
gradle buildPlugin
```

This will:
- Download the IntelliJ Platform SDK
- Compile the Kotlin source code
- Package the plugin as a ZIP file
- Output: `build/distributions/opencode-jetbrains-plugin-1.0.0.zip`

### Step 3: Verify the Build

Check that the plugin ZIP was created:
```bash
ls -lh build/distributions/
```

## Installing the Plugin

### Method 1: Install from Disk (Recommended for Testing)

1. Open your JetBrains IDE (IntelliJ IDEA, PyCharm, WebStorm, etc.)
2. Go to **Settings/Preferences** (Windows/Linux: `Ctrl+Alt+S`, macOS: `Cmd+,`)
3. Navigate to **Plugins**
4. Click the gear icon (⚙️) at the top
5. Select **Install Plugin from Disk...**
6. Browse to `opencode-jetbrains-plugin/build/distributions/opencode-jetbrains-plugin-1.0.0.zip`
7. Click **OK**
8. Restart your IDE when prompted

### Method 2: Run in Development Mode

For development and testing, you can run the plugin in a sandboxed IDE instance:

```bash
./gradlew runIde
```

This will:
- Download a clean IDE instance
- Install your plugin
- Launch the IDE with the plugin loaded
- Changes to code require rebuilding and restarting

## Using the Plugin

### First Launch

1. After restarting your IDE, you should see a new tool window icon on the right sidebar labeled **"OpenCode Chat"**
2. Click the icon to open the chat panel
3. The plugin will attempt to start the OpenCode server automatically
   - If successful: You'll see "OpenCode AI Assistant is connected"
   - If failed: You'll see a message about OpenCode not being installed

### Sending Messages

1. Type your question or request in the text input area at the bottom
2. Press **Ctrl+Enter** (Windows/Linux) or **Cmd+Enter** (macOS)
   - Or click the **Send** button
3. Wait for the OpenCode AI assistant to respond
4. The conversation history appears in the main panel

### Available Actions

Access these from the tool window toolbar:

- **Clear Chat** (🗑️): Clear the conversation history
- **Restart Server** (🔄): Restart the OpenCode server if it becomes unresponsive

## Troubleshooting

### Server Not Starting

**Problem**: Message shows "OpenCode server is not running"

**Solutions**:
1. Verify OpenCode is installed:
   ```bash
   which opencode  # Unix/Linux/macOS
   where opencode  # Windows
   ```

2. Check if port 3000 is available:
   ```bash
   # Unix/Linux/macOS
   lsof -i :3000
   
   # Windows
   netstat -ano | findstr :3000
   ```

3. Try starting OpenCode manually to see error messages:
   ```bash
   opencode serve --port 3000
   ```

4. Use the "Restart Server" action from the plugin toolbar

### Network/Connection Errors

**Problem**: Chat sends messages but no response appears

**Solutions**:
1. Check IDE logs for detailed error messages:
   - **Help** → **Show Log in Finder/Explorer**
   - Look for entries containing "OpenCode" or "opencode.plugin"

2. Test the server directly:
   ```bash
   curl http://localhost:3000/health
   # Should return 200 OK if server is running
   ```

3. Restart the OpenCode server using the plugin action

### Build Errors

**Problem**: `./gradlew buildPlugin` fails

**Solutions**:
1. Ensure you have Java 21 or later:
   ```bash
   java -version
   ```

2. Clean and rebuild:
   ```bash
   ./gradlew clean buildPlugin
   ```

3. Check for network access to download dependencies:
   - IntelliJ Platform SDK downloads from JetBrains servers
   - Maven dependencies from Maven Central

## Configuration

### Changing the Server Port

The default OpenCode server port is 3000. To change it:

1. Edit `src/main/kotlin/com/opencode/plugin/services/OpenCodeServerService.kt`
2. Modify the `DEFAULT_PORT` constant
3. Rebuild the plugin

### Customizing Server Command

The plugin launches OpenCode with: `opencode serve --port 3000`

To customize the command:
1. Edit `OpenCodeServerService.kt`
2. Modify the `ProcessBuilder` command in the `startServer()` method
3. Rebuild the plugin

## Development Setup

### Setting Up Your IDE for Plugin Development

1. Open the `opencode-jetbrains-plugin` directory in IntelliJ IDEA
2. Import as a Gradle project
3. Let Gradle sync and download dependencies
4. You can now edit the code with full IDE support

### Running Tests

```bash
./gradlew test
```

### Code Style

The project follows standard Kotlin conventions:
- Use 4 spaces for indentation
- Follow Kotlin naming conventions
- Use meaningful variable and function names

## Uninstalling

1. Go to **Settings/Preferences** → **Plugins**
2. Find "OpenCode AI Assistant" in the installed plugins list
3. Click the gear icon next to it
4. Select **Uninstall**
5. Restart the IDE

## Support & Contributing

### Getting Help

- Check the main README: `opencode-jetbrains-plugin/README.md`
- Open an issue on GitHub
- Check OpenCode documentation at https://opencode.ai

### Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Additional Resources

- [IntelliJ Platform SDK Documentation](https://plugins.jetbrains.com/docs/intellij/)
- [Kotlin Language Reference](https://kotlinlang.org/docs/reference/)
- [Gradle Build Tool](https://gradle.org/)
- [OpenCode Documentation](https://opencode.ai)

## Version History

### 1.0.0 (Initial Release)
- Chat panel interface
- Automatic OpenCode server management
- Clear chat and restart server actions
- Support for IntelliJ IDEA 2024.2.x
