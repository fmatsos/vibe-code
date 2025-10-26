package com.opencode.plugin.services

import com.intellij.openapi.components.Service
import com.intellij.openapi.project.Project
import com.opencode.plugin.models.ChatMessage

@Service(Service.Level.PROJECT)
class OpenCodeProjectService(private val project: Project) {
    private val chatHistory = mutableListOf<ChatMessage>()
    
    fun addMessage(message: ChatMessage) {
        chatHistory.add(message)
    }
    
    fun getChatHistory(): List<ChatMessage> = chatHistory.toList()
    
    fun clearHistory() {
        chatHistory.clear()
    }
}
