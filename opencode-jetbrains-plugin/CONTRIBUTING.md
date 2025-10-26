# Contributing to OpenCode JetBrains Plugin

Thank you for your interest in contributing to the OpenCode JetBrains Plugin! This document provides guidelines and information for contributors.

## Development Environment Setup

### Prerequisites

- Java JDK 21 or later
- IntelliJ IDEA (Community or Ultimate Edition)
- Git
- Gradle (included via wrapper)

### Getting Started

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd vibe-code/opencode-jetbrains-plugin
   ```

2. **Open in IntelliJ IDEA**
   - File → Open → Select the `opencode-jetbrains-plugin` directory
   - Wait for Gradle to sync

3. **Run the plugin in development mode**
   ```bash
   ./gradlew runIde
   ```

## Project Structure

```
opencode-jetbrains-plugin/
├── src/main/
│   ├── kotlin/com/opencode/plugin/
│   │   ├── actions/           # User actions (Clear, Restart, etc.)
│   │   ├── listeners/         # Application lifecycle listeners
│   │   ├── models/            # Data models
│   │   ├── services/          # Business logic services
│   │   │   ├── OpenCodeServerService.kt  # Server management
│   │   │   └── OpenCodeProjectService.kt # Project-level state
│   │   └── ui/                # User interface components
│   │       ├── OpenCodeChatPanel.kt      # Main chat UI
│   │       └── OpenCodeToolWindowFactory.kt
│   └── resources/
│       ├── META-INF/
│       │   └── plugin.xml     # Plugin configuration
│       └── icons/
│           └── opencode.svg   # Plugin icon
├── build.gradle.kts           # Build configuration
└── README.md
```

## Code Guidelines

### Kotlin Style

Follow the [Kotlin Coding Conventions](https://kotlinlang.org/docs/coding-conventions.html):

- **Naming**: Use camelCase for functions and properties, PascalCase for classes
- **Indentation**: 4 spaces (no tabs)
- **Line Length**: Prefer 120 characters max
- **Braces**: Opening brace on the same line

Example:
```kotlin
class MyService {
    private val logger = logger<MyService>()
    
    fun doSomething(): Boolean {
        try {
            // Implementation
            return true
        } catch (e: Exception) {
            logger.error("Error occurred", e)
            return false
        }
    }
}
```

### IntelliJ Platform API

- Use **Service** classes for stateful components
- Implement **AnAction** for user actions
- Use **ToolWindowFactory** for UI windows
- Follow the **read/write action** model for PSI access
- Use **Application.executeOnPooledThread** for background tasks
- Update UI in **EDT** (Event Dispatch Thread) with `SwingUtilities.invokeLater`

### Error Handling

- Always catch and log exceptions appropriately
- Use IntelliJ's `Logger` for logging
- Provide user-friendly error messages
- Don't expose stack traces to users

Example:
```kotlin
private val log = logger<OpenCodeServerService>()

fun performAction() {
    try {
        // Action logic
    } catch (e: Exception) {
        log.error("Failed to perform action", e)
        Messages.showErrorDialog(
            "Action failed. Please check the logs for details.",
            "Error"
        )
    }
}
```

## Making Changes

### Workflow

1. **Create a feature branch**
   ```bash
   git checkout -b feature/my-new-feature
   ```

2. **Make your changes**
   - Write clean, documented code
   - Follow the existing code style
   - Add comments for complex logic

3. **Test your changes**
   ```bash
   # Run in development mode
   ./gradlew runIde
   
   # Build the plugin
   ./gradlew buildPlugin
   ```

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat: Add new feature description"
   ```
   
   Use [Conventional Commits](https://www.conventionalcommits.org/):
   - `feat:` New feature
   - `fix:` Bug fix
   - `docs:` Documentation changes
   - `refactor:` Code refactoring
   - `test:` Test additions/changes
   - `chore:` Build/tooling changes

5. **Push and create a pull request**
   ```bash
   git push origin feature/my-new-feature
   ```

### Testing Your Changes

1. **Manual Testing**
   - Run `./gradlew runIde`
   - Test all affected features
   - Try edge cases and error scenarios
   - Test with different IDE versions if possible

2. **Code Review Checklist**
   - [ ] Code compiles without errors
   - [ ] Plugin runs in development IDE
   - [ ] All features work as expected
   - [ ] No exceptions in logs
   - [ ] Code follows project conventions
   - [ ] Comments added for complex logic
   - [ ] No unnecessary code or imports

## Common Tasks

### Adding a New Action

1. Create a new class in `actions/` package:
   ```kotlin
   package com.opencode.plugin.actions
   
   import com.intellij.openapi.actionSystem.AnAction
   import com.intellij.openapi.actionSystem.AnActionEvent
   
   class MyNewAction : AnAction() {
       override fun actionPerformed(e: AnActionEvent) {
           // Implementation
       }
   }
   ```

2. Register in `plugin.xml`:
   ```xml
   <action id="OpenCode.MyNewAction"
           class="com.opencode.plugin.actions.MyNewAction"
           text="My Action"
           description="Description of my action"
           icon="AllIcons.Actions.Execute"/>
   ```

### Adding a New Service

1. Create the service class:
   ```kotlin
   package com.opencode.plugin.services
   
   import com.intellij.openapi.components.Service
   
   @Service
   class MyService {
       // Implementation
   }
   ```

2. Register in `plugin.xml`:
   ```xml
   <applicationService serviceImplementation="com.opencode.plugin.services.MyService"/>
   ```

3. Use the service:
   ```kotlin
   val service = service<MyService>()
   ```

### Modifying the UI

The main UI is in `OpenCodeChatPanel.kt`. When modifying:

- Use IntelliJ's UI components (JB* classes)
- Ensure thread safety (EDT vs background threads)
- Test with different themes (Light, Dark, High Contrast)
- Follow the IDE's UI guidelines

### Debugging

1. **Run with debugging**
   ```bash
   ./gradlew runIde --debug-jvm
   ```

2. **Set breakpoints** in IntelliJ IDEA

3. **Check logs**
   - In the sandbox IDE: Help → Show Log
   - Look for errors and warnings related to the plugin

## Pull Request Process

1. **Create a clear PR title**
   - Use conventional commit format
   - Example: "feat: Add code completion support"

2. **Provide a detailed description**
   - What does this PR do?
   - Why is this change needed?
   - How has it been tested?
   - Screenshots (if UI changes)

3. **Link related issues**
   - Use "Fixes #123" or "Relates to #456"

4. **Be responsive to feedback**
   - Address review comments promptly
   - Update the PR as needed
   - Ask questions if unclear

## Areas for Contribution

### High Priority

- [ ] Improve error handling and user feedback
- [ ] Add configuration UI for server settings
- [ ] Support for multiple OpenCode instances
- [ ] Integration with IDE's VCS features
- [ ] Context extraction from current file/selection

### Medium Priority

- [ ] Add keyboard shortcuts configuration
- [ ] Improve chat UI (markdown rendering, syntax highlighting)
- [ ] Add conversation history persistence
- [ ] Support for chat templates/snippets
- [ ] Integration with IDE's notification system

### Low Priority/Nice to Have

- [ ] Theme customization for chat panel
- [ ] Export chat history
- [ ] Voice input support
- [ ] Multi-language support
- [ ] Analytics and usage statistics

## Resources

### IntelliJ Platform SDK

- [Official Documentation](https://plugins.jetbrains.com/docs/intellij/)
- [IntelliJ Platform SDK Code Samples](https://github.com/JetBrains/intellij-sdk-code-samples)
- [IntelliJ Platform Explorer](https://plugins.jetbrains.com/intellij-platform-explorer/)

### Kotlin

- [Kotlin Documentation](https://kotlinlang.org/docs/)
- [Kotlin Style Guide](https://kotlinlang.org/docs/coding-conventions.html)

### Build Tools

- [Gradle IntelliJ Plugin](https://github.com/JetBrains/gradle-intellij-plugin)
- [Gradle Documentation](https://docs.gradle.org/)

## Questions?

If you have questions:
- Open a discussion on GitHub
- Check existing issues and PRs
- Review the documentation

## License

By contributing, you agree that your contributions will be licensed under the same license as the project.

Thank you for contributing! 🎉
