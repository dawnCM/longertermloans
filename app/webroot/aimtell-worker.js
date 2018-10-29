// proper initialization
if( 'function' === typeof importScripts) {
	importScripts('https://cdn.aimtell.com/sdk/aimtell-worker-sdk.js');
	addEventListener('message', onMessage);

	function onMessage(e) { 
	// do some work here 
	}    
}