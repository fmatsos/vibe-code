# Quick Start Guide - OpenCode JetBrains Plugin

Get up and running with the OpenCode AI assistant in your IDE in just a few minutes!

## Prerequisites

✅ IntelliJ IDEA 2024.2+ (or compatible JetBrains IDE)  
✅ Java 21 or later  
✅ OpenCode CLI installed

## Step 1: Install OpenCode CLI

If you haven't already installed OpenCode:

```bash
# Using npm
npm install -g opencode

# OR using pip
pip install opencode

# Verify installation
opencode --version
```

## Step 2: Build the Plugin

```bash
# Navigate to the plugin directory
cd opencode-jetbrains-plugin

# Build the plugin (this may take a few minutes)
./gradlew buildPlugin
```

The plugin ZIP will be created at:
```
build/distributions/opencode-jetbrains-plugin-1.0.0.zip
```

## Step 3: Install Plugin in IDE

1. Open IntelliJ IDEA (or your JetBrains IDE)
2. Press `Ctrl+Alt+S` (Windows/Linux) or `Cmd+,` (macOS) to open Settings
3. Go to **Plugins**
4. Click the gear icon ⚙️ at the top
5. Select **Install Plugin from Disk...**
6. Navigate to and select the plugin ZIP file
7. Click **OK**
8. **Restart your IDE** when prompted

## Step 4: Open the Chat Panel

After restart:
1. Look for the **OpenCode Chat** icon in the right sidebar  
   (It looks like a terminal/code symbol)
2. Click the icon to open the chat panel
3. You should see: "OpenCode AI Assistant is connected."

## Step 5: Start Chatting!

1. Type your question in the input field at the bottom
2. Press `Ctrl+Enter` or click **Send Message**
3. Wait for the AI response
4. Continue the conversation!

### Example Questions to Try:

```
How do I create a singleton in Kotlin?
```

```
Explain the difference between val and var
```

```
Show me how to use coroutines for async operations
```

```
What's the best way to handle null safety?
```

## Keyboard Shortcuts

- `Ctrl+Enter` - Send message
- `Enter` - New line in message
- `Escape` - Close tool window

## Troubleshooting

### ❌ "OpenCode server is not running"

**Solution:**
```bash
# Check if OpenCode is installed
which opencode

# If not found, install it
npm install -g opencode

# Try restarting the server from the plugin
# Click the restart button (🔄) in the chat panel
```

### ❌ Build fails with network errors

**Solution:**
- Ensure you have internet connection
- The build downloads IntelliJ Platform SDK (~500MB)
- Try again with: `./gradlew clean buildPlugin`

### ❌ IDE doesn't show the plugin after install

**Solution:**
- Make sure you restarted the IDE
- Check if it's compatible: Settings → Plugins → Installed
- Try reinstalling the plugin

## What's Next?

- Read the full [README](README.md) for detailed features
- Check [INSTALLATION.md](INSTALLATION.md) for advanced setup
- Explore [ARCHITECTURE.md](ARCHITECTURE.md) to understand how it works
- Contribute! See [CONTRIBUTING.md](CONTRIBUTING.md)

## Need Help?

- Check the [Troubleshooting section](INSTALLATION.md#troubleshooting) in INSTALLATION.md
- View IDE logs: **Help** → **Show Log in Finder/Explorer**
- Open an issue on GitHub

## Tips for Better Results

1. **Be specific** in your questions
   - ❌ "How do I use Kotlin?"
   - ✅ "How do I create a data class with validation in Kotlin?"

2. **Provide context** when needed
   - "I'm building a REST API with Ktor..."
   - "My Android app needs to..."

3. **Ask follow-up questions**
   - The AI remembers your conversation!
   - Build on previous answers

4. **Use the chat for:**
   - Code explanations
   - Best practices
   - Debugging help
   - Architecture advice
   - Quick references

## Common Use Cases

### 🔍 Learn New Syntax
```
You: How do I filter a list in Kotlin?

OpenCode: You can use the filter function:
val numbers = listOf(1, 2, 3, 4, 5)
val evens = numbers.filter { it % 2 == 0 }
```

### 🐛 Debug Issues
```
You: I'm getting a NullPointerException when accessing user.name

OpenCode: Use safe call operator or let:
val name = user?.name ?: "Unknown"
// or
user?.let { println(it.name) }
```

### 🏗️ Architecture Questions
```
You: Should I use MVVM or MVI for my Android app?

OpenCode: Both are valid! MVVM is more common and simpler...
```

### 📚 Quick References
```
You: What are the different scope functions in Kotlin?

OpenCode: Kotlin has 5 scope functions:
- let: returns lambda result, uses 'it'
- run: returns lambda result, uses 'this'
...
```

## Enjoy Coding with AI! 🚀

Happy coding! The OpenCode assistant is here to help you be more productive and learn faster.

---

**Version:** 1.0.0  
**Last Updated:** 2025-10-26
