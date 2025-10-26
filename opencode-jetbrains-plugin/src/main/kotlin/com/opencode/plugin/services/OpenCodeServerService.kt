package com.opencode.plugin.services

import com.intellij.openapi.components.Service
import com.intellij.openapi.diagnostic.logger
import java.io.BufferedReader
import java.io.InputStreamReader
import java.net.HttpURLConnection
import java.net.URL

@Service
class OpenCodeServerService {
    private var serverProcess: Process? = null
    private var serverPort: Int = 3000
    private val log = logger<OpenCodeServerService>()
    
    companion object {
        const val DEFAULT_PORT = 3000
        const val OPENCODE_COMMAND = "opencode"
    }
    
    init {
        // Start the server when the service is initialized
        startServer()
    }
    
    fun startServer(): Boolean {
        if (isServerRunning()) {
            log.info("OpenCode server is already running")
            return true
        }
        
        return try {
            log.info("Starting OpenCode server on port $serverPort")
            
            // Check if opencode is available in PATH
            if (!isOpenCodeInstalled()) {
                log.warn("OpenCode is not installed. Please install it first.")
                return false
            }
            
            val processBuilder = ProcessBuilder(
                OPENCODE_COMMAND,
                "serve",
                "--port", serverPort.toString()
            )
            
            processBuilder.redirectErrorStream(true)
            serverProcess = processBuilder.start()
            
            // Give the server a moment to start
            Thread.sleep(2000)
            
            val started = isServerRunning()
            if (started) {
                log.info("OpenCode server started successfully")
            } else {
                log.warn("OpenCode server failed to start")
            }
            
            started
        } catch (e: Exception) {
            log.error("Failed to start OpenCode server", e)
            false
        }
    }
    
    fun stopServer() {
        try {
            serverProcess?.let {
                log.info("Stopping OpenCode server")
                it.destroy()
                it.waitFor()
                serverProcess = null
                log.info("OpenCode server stopped")
            }
        } catch (e: Exception) {
            log.error("Failed to stop OpenCode server", e)
        }
    }
    
    fun restartServer(): Boolean {
        stopServer()
        Thread.sleep(1000)
        return startServer()
    }
    
    fun isServerRunning(): Boolean {
        return try {
            val url = URL("http://localhost:$serverPort/health")
            val connection = url.openConnection() as HttpURLConnection
            connection.requestMethod = "GET"
            connection.connectTimeout = 1000
            connection.readTimeout = 1000
            
            val responseCode = connection.responseCode
            connection.disconnect()
            
            responseCode == 200
        } catch (e: Exception) {
            false
        }
    }
    
    private fun isOpenCodeInstalled(): Boolean {
        return try {
            val process = ProcessBuilder("which", OPENCODE_COMMAND).start()
            val exitCode = process.waitFor()
            exitCode == 0
        } catch (e: Exception) {
            // Try Windows version
            try {
                val process = ProcessBuilder("where", OPENCODE_COMMAND).start()
                val exitCode = process.waitFor()
                exitCode == 0
            } catch (e: Exception) {
                false
            }
        }
    }
    
    fun sendMessage(message: String): String {
        if (!isServerRunning()) {
            return "Error: OpenCode server is not running"
        }
        
        return try {
            val url = URL("http://localhost:$serverPort/chat")
            val connection = url.openConnection() as HttpURLConnection
            connection.requestMethod = "POST"
            connection.setRequestProperty("Content-Type", "application/json")
            connection.doOutput = true
            
            val jsonInput = """{"message": "$message"}"""
            connection.outputStream.use { os ->
                val input = jsonInput.toByteArray(Charsets.UTF_8)
                os.write(input, 0, input.size)
            }
            
            val responseCode = connection.responseCode
            if (responseCode == 200) {
                BufferedReader(InputStreamReader(connection.inputStream)).use { reader ->
                    reader.readText()
                }
            } else {
                "Error: Server returned code $responseCode"
            }
        } catch (e: Exception) {
            log.error("Failed to send message to OpenCode server", e)
            "Error: ${e.message}"
        }
    }
    
    fun getServerPort(): Int = serverPort
    
    fun setServerPort(port: Int) {
        if (port != serverPort) {
            serverPort = port
            if (isServerRunning()) {
                restartServer()
            }
        }
    }
}
