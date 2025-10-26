package com.opencode.plugin.actions

import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.wm.ToolWindowManager

class ClearChatAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val project = e.project ?: return
        val toolWindow = ToolWindowManager.getInstance(project).getToolWindow("OpenCode Chat") ?: return
        
        // Access the chat panel and clear it
        val contentManager = toolWindow.contentManager
        if (contentManager.contentCount > 0) {
            val component = contentManager.getContent(0)?.component
            if (component is com.opencode.plugin.ui.OpenCodeChatPanel) {
                component.clearChat()
            }
        }
    }
}
