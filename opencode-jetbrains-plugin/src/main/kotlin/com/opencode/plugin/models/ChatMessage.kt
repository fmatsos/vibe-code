package com.opencode.plugin.models

import java.time.LocalDateTime

data class ChatMessage(
    val content: String,
    val isUser: Boolean,
    val timestamp: LocalDateTime = LocalDateTime.now()
)
