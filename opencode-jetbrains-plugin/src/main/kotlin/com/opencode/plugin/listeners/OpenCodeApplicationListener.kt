package com.opencode.plugin.listeners

import com.intellij.ide.AppLifecycleListener
import com.intellij.openapi.components.service
import com.opencode.plugin.services.OpenCodeServerService

class OpenCodeApplicationListener : AppLifecycleListener {
    override fun appWillBeClosed(isRestart: Boolean) {
        // Stop the OpenCode server when the application is closing
        val serverService = service<OpenCodeServerService>()
        serverService.stopServer()
    }
}
