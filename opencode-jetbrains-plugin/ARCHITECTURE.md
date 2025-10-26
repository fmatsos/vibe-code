# OpenCode JetBrains Plugin - Architecture

This document describes the architecture and design of the OpenCode JetBrains Plugin.

## Overview

The plugin follows IntelliJ Platform's architecture patterns, utilizing Services, Tool Windows, and Actions to integrate OpenCode AI assistant into the IDE.

## Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                        IntelliJ IDEA                            │
│                                                                 │
│  ┌───────────────────────────────────────────────────────────┐ │
│  │                  OpenCode Plugin                          │ │
│  │                                                           │ │
│  │  ┌─────────────────────────────────────────────────────┐ │ │
│  │  │          UI Layer (Tool Window)                     │ │ │
│  │  │                                                     │ │ │
│  │  │  ┌─────────────────────────────────────────────┐   │ │ │
│  │  │  │   OpenCodeToolWindowFactory                 │   │ │ │
│  │  │  │   Creates tool window instance              │   │ │ │
│  │  │  └────────────────┬────────────────────────────┘   │ │ │
│  │  │                   │                                 │ │ │
│  │  │                   ▼                                 │ │ │
│  │  │  ┌─────────────────────────────────────────────┐   │ │ │
│  │  │  │   OpenCodeChatPanel                         │   │ │ │
│  │  │  │  - Text input field                         │   │ │ │
│  │  │  │  - Chat history display                     │   │ │ │
│  │  │  │  - Send button                              │   │ │ │
│  │  │  │  - Keyboard shortcuts (Ctrl+Enter)          │   │ │ │
│  │  │  └────────────┬────────────────────────────────┘   │ │ │
│  │  └───────────────┼──────────────────────────────────┘ │ │
│  │                  │                                     │ │
│  │  ┌───────────────┼──────────────────────────────────┐ │ │
│  │  │     Service Layer                                │ │ │
│  │  │               │                                  │ │ │
│  │  │   ┌───────────▼──────────────────────┐          │ │ │
│  │  │   │  OpenCodeProjectService          │          │ │ │
│  │  │   │  - Chat history management       │          │ │ │
│  │  │   │  - Per-project state             │          │ │ │
│  │  │   └──────────────────────────────────┘          │ │ │
│  │  │                                                  │ │ │
│  │  │   ┌──────────────────────────────────┐          │ │ │
│  │  │   │  OpenCodeServerService           │          │ │ │
│  │  │   │  - Server lifecycle management   │          │ │ │
│  │  │   │  - Start/Stop/Restart server     │          │ │ │
│  │  │   │  - Health check                  │          │ │ │
│  │  │   │  - Message sending               │          │ │ │
│  │  │   └─────────────┬────────────────────┘          │ │ │
│  │  └─────────────────┼────────────────────────────────┘ │ │
│  │                    │                                   │ │
│  │  ┌─────────────────┼────────────────────────────────┐ │ │
│  │  │     Actions Layer                                │ │ │
│  │  │                 │                                │ │ │
│  │  │   ┌─────────────▼──────────┐                    │ │ │
│  │  │   │  ClearChatAction       │                    │ │ │
│  │  │   │  RestartServerAction   │                    │ │ │
│  │  │   └────────────────────────┘                    │ │ │
│  │  └──────────────────────────────────────────────────┘ │ │
│  │                                                        │ │
│  │  ┌──────────────────────────────────────────────────┐ │ │
│  │  │     Listeners                                    │ │ │
│  │  │   ┌──────────────────────────────────────────┐  │ │ │
│  │  │   │  OpenCodeApplicationListener             │  │ │ │
│  │  │   │  - App lifecycle monitoring              │  │ │ │
│  │  │   │  - Cleanup on shutdown                   │  │ │ │
│  │  │   └──────────────────────────────────────────┘  │ │ │
│  │  └──────────────────────────────────────────────────┘ │ │
│  └────────────────────────────────────────────────────────┘ │
└─────────────────┬──────────────────────────────────────────┘
                  │
                  │ HTTP Requests (localhost:3000)
                  ▼
         ┌─────────────────────┐
         │  OpenCode Server    │
         │  (External Process) │
         │                     │
         │  - Port: 3000       │
         │  - /health endpoint │
         │  - /chat endpoint   │
         └─────────────────────┘
```

## Component Details

### 1. UI Layer

#### OpenCodeToolWindowFactory
- **Purpose**: Factory for creating the tool window
- **Lifecycle**: Created when IDE starts
- **Responsibilities**:
  - Instantiate `OpenCodeChatPanel`
  - Register with tool window manager
  - Configure tool window appearance (icon, position, etc.)

#### OpenCodeChatPanel
- **Purpose**: Main user interface for the chat
- **Type**: JPanel with custom components
- **Components**:
  - Chat history area (JBTextArea, read-only)
  - Input field (JBTextArea, editable)
  - Send button (JButton)
- **Interactions**:
  - Captures user input
  - Displays messages
  - Handles keyboard shortcuts
  - Communicates with services

### 2. Service Layer

#### OpenCodeServerService
- **Scope**: Application-level (singleton)
- **Purpose**: Manages OpenCode server lifecycle
- **Key Methods**:
  ```kotlin
  fun startServer(): Boolean
  fun stopServer()
  fun restartServer(): Boolean
  fun isServerRunning(): Boolean
  fun sendMessage(message: String): String
  ```
- **Implementation Details**:
  - Uses `ProcessBuilder` to launch OpenCode
  - Monitors server health via HTTP endpoint
  - Handles server errors and restarts
  - Thread-safe operations

#### OpenCodeProjectService
- **Scope**: Project-level (one per project)
- **Purpose**: Manages project-specific plugin state
- **Key Methods**:
  ```kotlin
  fun addMessage(message: ChatMessage)
  fun getChatHistory(): List<ChatMessage>
  fun clearHistory()
  ```
- **Data Storage**: In-memory (not persisted)

### 3. Actions

#### ClearChatAction
- **Trigger**: User clicks toolbar button or menu item
- **Effect**: Clears chat history and resets UI

#### RestartServerAction
- **Trigger**: User clicks restart button
- **Effect**: Stops and restarts OpenCode server
- **UI Feedback**: Shows confirmation dialog

### 4. Listeners

#### OpenCodeApplicationListener
- **Purpose**: Handle application lifecycle events
- **Events Handled**:
  - `appWillBeClosed`: Cleanup before shutdown
- **Actions**: Stops OpenCode server gracefully

### 5. Models

#### ChatMessage
- **Type**: Data class
- **Fields**:
  - `content: String` - Message text
  - `isUser: Boolean` - Whether message is from user or AI
  - `timestamp: LocalDateTime` - When message was created

## Data Flow

### Sending a Message

```
User types message
      ↓
[OpenCodeChatPanel]
  - Capture input
  - Add to chat history
  - Clear input field
      ↓
[OpenCodeProjectService]
  - Store message in history
      ↓
[OpenCodeServerService]
  - Send HTTP POST to localhost:3000/chat
  - Wait for response
      ↓
[OpenCode Server]
  - Process message
  - Generate AI response
      ↓
[OpenCodeServerService]
  - Receive response
      ↓
[OpenCodeChatPanel]
  - Display response in UI (EDT)
      ↓
[OpenCodeProjectService]
  - Store AI response in history
```

### Server Lifecycle

```
IDE Starts
      ↓
[OpenCodeServerService] initialized
      ↓
Check if OpenCode installed
      ↓
Launch server process (opencode serve --port 3000)
      ↓
Wait 2 seconds
      ↓
Health check (GET localhost:3000/health)
      ↓
Server Ready ✓
      ↓
... IDE runs ...
      ↓
IDE Closing
      ↓
[OpenCodeApplicationListener]
      ↓
Stop server process
      ↓
Shutdown ✓
```

## Threading Model

### Thread Safety Considerations

1. **UI Updates**: Must occur in EDT (Event Dispatch Thread)
   ```kotlin
   SwingUtilities.invokeLater {
       // Update UI components
   }
   ```

2. **Background Tasks**: Use pooled threads for I/O
   ```kotlin
   ApplicationManager.getApplication().executeOnPooledThread {
       // Network calls, file I/O
   }
   ```

3. **Service Access**: Services are thread-safe via IntelliJ's service infrastructure

## Configuration

### plugin.xml

Key configurations:
- **Plugin metadata**: ID, name, description, vendor
- **Extension points**: Tool windows, services
- **Actions**: Clear chat, restart server
- **Listeners**: Application lifecycle

### Build Configuration

- **Kotlin version**: 2.0.21
- **Target platform**: IntelliJ IDEA 2024.2
- **Java version**: 21
- **Gradle plugin**: IntelliJ Platform Gradle Plugin 2.1.0

## Communication Protocol

### OpenCode Server API

#### Health Check
```
GET /health
Response: 200 OK
```

#### Send Message
```
POST /chat
Content-Type: application/json

{
  "message": "User's question or request"
}

Response: 200 OK
Content-Type: application/json

{
  "response": "AI assistant's response"
}
```

## Error Handling

### Server Failures
- Health check timeout → Show "server not running" message
- Start failure → Log error, notify user
- Connection error during message → Display error in chat

### UI Errors
- Exception in EDT → Log and show error dialog
- Background task failure → Log and notify user

### Graceful Degradation
- If OpenCode not installed → Show setup instructions
- If port in use → Suggest alternative or show error

## Future Enhancements

### Planned Features
1. **Configuration UI**: Allow users to customize port, command, etc.
2. **Context Awareness**: Send current file/selection to AI
3. **Persistent History**: Save chat history to disk
4. **Multiple Sessions**: Support multiple concurrent chats
5. **Markdown Rendering**: Rich formatting in chat panel

### Extensibility Points
- Custom AI providers (not just OpenCode)
- Plugin extensions for domain-specific features
- Integration with other IDE features (VCS, debugger, etc.)

## Testing Strategy

### Manual Testing
- Start/stop server functionality
- Send/receive messages
- UI responsiveness
- Error scenarios

### Integration Testing (Future)
- Mock server for testing communication
- UI component testing
- Service lifecycle testing

## Performance Considerations

1. **Server Startup**: 2-3 seconds typical
2. **Message Latency**: Depends on OpenCode response time
3. **Memory Usage**: Minimal (chat history in memory only)
4. **CPU Usage**: Idle when not in use

## Security

- **Local Only**: All communication via localhost
- **No External Connections**: Plugin doesn't call external APIs
- **Process Isolation**: OpenCode runs as separate process
- **No Credentials**: No authentication tokens stored

## Dependencies

### Core Dependencies
- Kotlin Standard Library
- IntelliJ Platform SDK
- Gson (for JSON parsing)

### Build Dependencies
- Gradle
- IntelliJ Platform Gradle Plugin
- Kotlin Gradle Plugin

---

*Last Updated: 2025-10-26*
