package com.opencode.plugin.actions

import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.components.service
import com.intellij.openapi.ui.Messages
import com.opencode.plugin.services.OpenCodeServerService

class RestartServerAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val serverService = service<OpenCodeServerService>()
        
        val result = Messages.showYesNoDialog(
            e.project,
            "Do you want to restart the OpenCode server?",
            "Restart Server",
            Messages.getQuestionIcon()
        )
        
        if (result == Messages.YES) {
            val success = serverService.restartServer()
            val message = if (success) {
                "OpenCode server restarted successfully"
            } else {
                "Failed to restart OpenCode server. Please check if OpenCode is installed."
            }
            
            Messages.showMessageDialog(
                e.project,
                message,
                "Server Status",
                Messages.getInformationIcon()
            )
        }
    }
}
