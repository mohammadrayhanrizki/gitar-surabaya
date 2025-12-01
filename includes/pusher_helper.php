<?php
/**
 * Pusher Helper - Centralized Pusher functionality
 */

// Global Pusher instance
$pusher = null;

/**
 * Initialize Pusher connection
 * @return Pusher\Pusher|null Pusher instance or null if failed
 */
function init_pusher() {
    global $pusher;
    
    if ($pusher !== null) {
        return $pusher;
    }
    
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $options = array(
        'cluster' => PUSHER_CLUSTER,
        'useTLS' => true
    );
    
    try {
        $pusher = new Pusher\Pusher(
            PUSHER_APP_KEY,
            PUSHER_APP_SECRET,
            PUSHER_APP_ID,
            $options
        );
        return $pusher;
    } catch (Exception $e) {
        error_log("Pusher initialization failed: " . $e->getMessage());
        return null;
    }
}

/**
 * Trigger Pusher event
 * @param string $channel Channel name
 * @param string $event Event name
 * @param array $data Event data
 * @return bool Success status
 */
function trigger_pusher($channel, $event, $data = []) {
    $pusher = init_pusher();
    
    if ($pusher === null) {
        return false;
    }
    
    try {
        $pusher->trigger($channel, $event, $data);
        return true;
    } catch (Exception $e) {
        error_log("Pusher trigger failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Trigger marketplace update
 * @param string $message Update message
 * @return bool Success status
 */
function trigger_marketplace_update($message = 'Data diperbarui') {
    return trigger_pusher('marketplace-channel', 'update-produk', ['message' => $message]);
}

/**
 * Trigger gallery update
 * @param string $message Update message
 * @return bool Success status
 */
function trigger_gallery_update($message = 'Galeri diperbarui') {
    return trigger_pusher('gallery-channel', 'update-gallery', ['message' => $message]);
}
?>
