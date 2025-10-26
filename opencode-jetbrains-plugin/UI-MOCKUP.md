# OpenCode Plugin - UI Mockup

This document describes the visual appearance and user experience of the OpenCode JetBrains Plugin.

## Tool Window Layout

```
┌────────────────────────────────────────────────────────────┐
│ OpenCode Chat                                    [⚙️] [🗑️] [🔄] │
├────────────────────────────────────────────────────────────┤
│                                                            │
│  ┌────────────────────────────────────────────────────┐   │
│  │ [System]: OpenCode AI Assistant is connected.      │   │
│  │ Type your message and press Ctrl+Enter or click    │   │
│  │ Send.                                              │   │
│  │                                                    │   │
│  │ [You]: How do I implement a singleton pattern in  │   │
│  │ Kotlin?                                            │   │
│  │                                                    │   │
│  │ [OpenCode]: In Kotlin, you can implement a        │   │
│  │ singleton pattern using the `object` keyword.     │   │
│  │ Here's an example:                                │   │
│  │                                                    │   │
│  │ ```kotlin                                          │   │
│  │ object MySingleton {                               │   │
│  │     fun doSomething() {                           │   │
│  │         println("Singleton method")               │   │
│  │     }                                             │   │
│  │ }                                                 │   │
│  │ ```                                               │   │
│  │                                                    │   │
│  │ [You]: Thanks! Can you show me how to make it    │   │
│  │ thread-safe?                                       │   │
│  │                                                    │   │
│  │ [OpenCode]: Kotlin's `object` is already thread-  │   │
│  │ safe! The Kotlin compiler ensures that the        │   │
│  │ singleton is initialized lazily and in a thread-  │   │
│  │ safe manner...                                    │   │
│  │                                                    │   │
│  │                    ↓ scroll for more ↓             │   │
│  └────────────────────────────────────────────────────┘   │
│                                                            │
├────────────────────────────────────────────────────────────┤
│  ┌────────────────────────────────────────────────────┐   │
│  │ Type your message here...                          │   │
│  │                                                    │   │
│  │                                                    │   │
│  └────────────────────────────────────────────────────┘   │
│                                           [Send Message]   │
└────────────────────────────────────────────────────────────┘
```

## UI Components Description

### 1. Title Bar
- **Location**: Top of the tool window
- **Elements**:
  - "OpenCode Chat" title text
  - Settings icon (⚙️) - Future: Opens configuration
  - Clear Chat icon (🗑️) - Clears conversation history
  - Restart Server icon (🔄) - Restarts OpenCode server

### 2. Chat Display Area
- **Type**: Scrollable text area
- **Characteristics**:
  - Read-only
  - Auto-scrolls to bottom on new messages
  - Line wrapping enabled
  - Message format: `[Sender]: Message content`
  - Senders: "System", "You", "OpenCode"
  
- **Message Types**:
  - **System messages**: Plugin status, errors, notifications
  - **User messages**: Questions, requests, commands
  - **AI messages**: OpenCode responses

### 3. Input Area
- **Type**: Multi-line text input
- **Characteristics**:
  - 3 rows default height
  - Expands with content
  - Line wrapping enabled
  - Placeholder: "Type your message here..."
  
- **Keyboard Shortcuts**:
  - `Ctrl+Enter` (Windows/Linux) / `Cmd+Enter` (macOS) - Send message
  - `Enter` - New line in message

### 4. Send Button
- **Location**: Bottom right
- **Label**: "Send Message" or "Send"
- **Action**: Sends message to OpenCode server
- **State**:
  - Enabled when text is present
  - Disabled when input is empty or server is not running

## Color Scheme

The plugin follows IntelliJ's theme system:

### Light Theme (IntelliJ Light)
- Background: `#FFFFFF`
- Text: `#000000`
- System messages: `#808080` (gray)
- User messages: `#0066CC` (blue)
- AI messages: `#008000` (green)
- Input field border: `#D0D0D0`
- Button: `#4A90E2`

### Dark Theme (Darcula)
- Background: `#2B2B2B`
- Text: `#A9B7C6`
- System messages: `#808080` (gray)
- User messages: `#6897BB` (light blue)
- AI messages: `#629755` (green)
- Input field border: `#323232`
- Button: `#4A88C7`

## User Interaction Flow

### First Time Use

```
User opens IDE
    ↓
Plugin automatically starts
    ↓
Tool window icon appears in right sidebar
    ↓
User clicks "OpenCode Chat" icon
    ↓
Tool window opens
    ↓
System message: "OpenCode AI Assistant is connected."
    (or error message if OpenCode not installed)
    ↓
User can start chatting
```

### Typical Chat Session

```
User types question in input field
    ↓
User presses Ctrl+Enter or clicks Send
    ↓
Message appears in chat area as "[You]: ..."
    ↓
Input field clears automatically
    ↓
"Thinking..." indicator (future enhancement)
    ↓
AI response appears as "[OpenCode]: ..."
    ↓
Chat scrolls to show new message
    ↓
User can continue conversation
```

### Error Scenario

```
User sends message
    ↓
Server connection fails
    ↓
Error message appears in chat:
"[System]: Error: OpenCode server is not running"
    ↓
User clicks Restart Server button
    ↓
Confirmation dialog appears
    ↓
User confirms
    ↓
Server restarts
    ↓
Success/failure message displayed
```

## Accessibility

### Keyboard Navigation
- `Tab` - Move between input field and buttons
- `Ctrl+Enter` - Send message (primary action)
- `Escape` - Close tool window (IDE standard)

### Screen Readers
- All UI elements have accessible labels
- Messages include sender information
- Button states announced (enabled/disabled)

## Responsive Behavior

### Window Resizing
- Chat area adjusts height automatically
- Input area maintains minimum 3-row height
- Horizontal scrolling disabled (text wraps)
- Vertical scrolling available in chat area

### Long Messages
- Text wraps at window width
- Code blocks preserve formatting
- Very long responses scroll automatically

## Future UI Enhancements

### Planned Improvements

1. **Markdown Rendering**
   - Code syntax highlighting
   - Bold/italic text
   - Lists and tables
   - Links

2. **Message Actions**
   - Copy message button
   - Delete individual message
   - Edit and resend

3. **Typing Indicator**
   - "OpenCode is typing..." animation
   - Response time estimation

4. **Context Menu**
   - Right-click on messages
   - Copy, delete, quote options

5. **Search**
   - Search within chat history
   - Highlight matches

6. **Export**
   - Save conversation to file
   - Copy all as markdown

## Example Screenshots (Textual)

### Example 1: Initial State
```
╔═══════════════════════════════════════════════════╗
║ OpenCode Chat                           [⚙️][🗑️][🔄] ║
╠═══════════════════════════════════════════════════╣
║                                                   ║
║ [System]: OpenCode AI Assistant is connected.    ║
║ Type your message and press Ctrl+Enter or click  ║
║ Send.                                             ║
║                                                   ║
║                                                   ║
║                                                   ║
║                                                   ║
║                                                   ║
╠═══════════════════════════════════════════════════╣
║ ┌───────────────────────────────────────────────┐ ║
║ │ Type your message here...                     │ ║
║ └───────────────────────────────────────────────┘ ║
║                                      [Send Message]║
╚═══════════════════════════════════════════════════╝
```

### Example 2: Active Conversation
```
╔═══════════════════════════════════════════════════╗
║ OpenCode Chat                           [⚙️][🗑️][🔄] ║
╠═══════════════════════════════════════════════════╣
║ [You]: Explain dependency injection in Kotlin    ║
║                                                   ║
║ [OpenCode]: Dependency injection is a design     ║
║ pattern where objects receive their dependencies ║
║ from external sources rather than creating them. ║
║                                                   ║
║ In Kotlin with Koin, you can do:                ║
║                                                   ║
║ val myModule = module {                          ║
║     single { MyRepository() }                    ║
║     factory { MyService(get()) }                 ║
║ }                                                ║
║                                                   ║
║ [You]: What's the difference between single and  ║
║ factory?                                          ║
║                                                   ║
║ [OpenCode]: Great question! Here's the key:     ║
║ - `single`: Creates ONE instance for the entire ║
║   app (singleton)                                ║
║ - `factory`: Creates a NEW instance every time  ║
║   it's requested...                              ║
╠═══════════════════════════════════════════════════╣
║ ┌───────────────────────────────────────────────┐ ║
║ │ Thanks! Can you show me how to inject into a  │ ║
║ │ ViewModel?                                    │ ║
║ └───────────────────────────────────────────────┘ ║
║                                      [Send Message]║
╚═══════════════════════════════════════════════════╝
```

### Example 3: Error State
```
╔═══════════════════════════════════════════════════╗
║ OpenCode Chat                           [⚙️][🗑️][🔄] ║
╠═══════════════════════════════════════════════════╣
║ [You]: How do I create a REST API in Kotlin?    ║
║                                                   ║
║ [System]: ⚠️ Error: OpenCode server is not       ║
║ running.                                          ║
║                                                   ║
║ Please ensure OpenCode is installed and try      ║
║ restarting the server using the restart button.  ║
║                                                   ║
║ To install OpenCode:                             ║
║ npm install -g opencode                          ║
║                                                   ║
╠═══════════════════════════════════════════════════╣
║ ┌───────────────────────────────────────────────┐ ║
║ │ Type your message here...                     │ ║
║ └───────────────────────────────────────────────┘ ║
║                                      [Send Message]║
╚═══════════════════════════════════════════════════╝
```

## Integration with IDE

### Tool Window Properties
- **ID**: "OpenCode Chat"
- **Icon**: Custom OpenCode icon (terminal/code symbol)
- **Default Position**: Right sidebar
- **Can Be Moved**: Yes (to any IDE panel)
- **Can Be Docked**: Yes
- **Can Be Floating**: Yes
- **Can Be Hidden**: Yes

### IDE Theme Integration
- Automatically adapts to IDE theme changes
- Respects user's font size preferences
- Uses IDE's standard UI components (JBTextArea, etc.)
- Follows IntelliJ UI guidelines

## Mobile/Compact View
For smaller windows or compact mode:
- Buttons show only icons (no text)
- Chat messages use smaller font
- Input area shrinks to 2 rows
- Margins reduced for space efficiency

---

*Note: This is a textual mockup. Actual UI will be rendered by IntelliJ's Swing components with proper theming and styling.*
