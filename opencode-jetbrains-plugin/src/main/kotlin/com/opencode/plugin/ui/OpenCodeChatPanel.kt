package com.opencode.plugin.ui

import com.intellij.openapi.application.ApplicationManager
import com.intellij.openapi.components.service
import com.intellij.openapi.project.Project
import com.intellij.ui.components.JBScrollPane
import com.intellij.ui.components.JBTextArea
import com.intellij.util.ui.JBUI
import com.opencode.plugin.models.ChatMessage
import com.opencode.plugin.services.OpenCodeProjectService
import com.opencode.plugin.services.OpenCodeServerService
import java.awt.BorderLayout
import java.awt.event.KeyAdapter
import java.awt.event.KeyEvent
import javax.swing.*

class OpenCodeChatPanel(private val project: Project) : JPanel(BorderLayout()) {
    private val chatArea = JBTextArea()
    private val inputField = JBTextArea(3, 40)
    private val sendButton = JButton("Send")
    private val serverService = service<OpenCodeServerService>()
    private val projectService = project.service<OpenCodeProjectService>()
    
    init {
        setupUI()
        setupListeners()
        displayWelcomeMessage()
    }
    
    private fun setupUI() {
        // Configure chat display area
        chatArea.isEditable = false
        chatArea.lineWrap = true
        chatArea.wrapStyleWord = true
        
        val scrollPane = JBScrollPane(chatArea)
        scrollPane.border = JBUI.Borders.empty(10)
        
        // Configure input field
        inputField.lineWrap = true
        inputField.wrapStyleWord = true
        
        // Create input panel
        val inputPanel = JPanel(BorderLayout())
        inputPanel.border = JBUI.Borders.empty(10)
        inputPanel.add(JBScrollPane(inputField), BorderLayout.CENTER)
        
        // Create button panel
        val buttonPanel = JPanel()
        buttonPanel.add(sendButton)
        inputPanel.add(buttonPanel, BorderLayout.SOUTH)
        
        // Add components to main panel
        add(scrollPane, BorderLayout.CENTER)
        add(inputPanel, BorderLayout.SOUTH)
    }
    
    private fun setupListeners() {
        sendButton.addActionListener { sendMessage() }
        
        inputField.addKeyListener(object : KeyAdapter() {
            override fun keyPressed(e: KeyEvent) {
                if (e.keyCode == KeyEvent.VK_ENTER && e.isControlDown) {
                    e.consume()
                    sendMessage()
                }
            }
        })
    }
    
    private fun displayWelcomeMessage() {
        val serverStatus = if (serverService.isServerRunning()) {
            "connected"
        } else {
            "not running (install OpenCode to use this plugin)"
        }
        
        appendToChatArea("System", "OpenCode AI Assistant is $serverStatus.\n" +
                "Type your message and press Ctrl+Enter or click Send.\n\n")
    }
    
    private fun sendMessage() {
        val message = inputField.text.trim()
        if (message.isEmpty()) return
        
        // Add user message to chat
        val userMessage = ChatMessage(message, isUser = true)
        projectService.addMessage(userMessage)
        appendToChatArea("You", message)
        
        // Clear input field
        inputField.text = ""
        
        // Send to OpenCode server in background
        ApplicationManager.getApplication().executeOnPooledThread {
            val response = serverService.sendMessage(message)
            
            // Update UI in EDT
            SwingUtilities.invokeLater {
                val assistantMessage = ChatMessage(response, isUser = false)
                projectService.addMessage(assistantMessage)
                appendToChatArea("OpenCode", response)
            }
        }
    }
    
    private fun appendToChatArea(sender: String, message: String) {
        chatArea.append("[$sender]: $message\n\n")
        chatArea.caretPosition = chatArea.document.length
    }
    
    fun clearChat() {
        chatArea.text = ""
        projectService.clearHistory()
        displayWelcomeMessage()
    }
}
