<script>

    /* Very ugly code that needs to be rewritten */

    function Notification(color, icon, message, type){
        var obj										= {};
        obj.progress								= 0;
        obj.fadeTime								= 1000;
        obj.fadeTicks								= 50;
        obj.fadeInterval							= 0;
        obj.opacity									= 1;
        obj.time									= 4;
        obj.ticks									= 500;
        obj.element									= null;
        obj.progress								= null;
        obj.progressPos								= 0;
        obj.progressIncrement						= 0;
        obj.Show									= function(){
            
            var iconHtml = "";

            switch(icon) {
                case "info":
                    iconHtml =  '<svg class="h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' +
                                '</svg>';
                    break;

                case "report":
                    iconHtml =  '<svg class="h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' + 
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />' +
                                '</svg>';
                    break;
                
                case "success":
                    iconHtml =  '<svg class="h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />' +
                                '</svg>';
                    break;

                default:
                iconHtml =  '<svg class="h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' +
                                '</svg>';
            }

            obj.element								= document.createElement('div');
            obj.element.innerHTML +=    '<div class="bg-white border-t-4 border-' + color + '-500 rounded-b text-' + color + '-900 px-4 py-3 shadow-md" role="alert">' +
                                            '<div class="flex">' +
                                                '<div class="py-1">' +
                                                    iconHtml +
                                                '</div>' +
                                                '<div>' +
                                                    '<p class="font-bold">' + type + '</p>' +
                                                    '<p class="text-sm">' + message + '</p>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>';
            obj.element = obj.element.firstChild;
            var progressDiv							= document.createElement('div');
            progressDiv.className					= 'ProgressDiv';
            obj.progress							= document.createElement('div');
            progressDiv.appendChild(obj.progress);
            obj.element.appendChild(progressDiv);
            obj.progressIncrement					= 100 / obj.ticks;
            document.getElementById('notifications').appendChild(obj.element);
            obj.StartWait();
        };
        obj.StartWait								= function(){
            if(obj.progressPos >= 100){
                obj.fadeInterval					= 1;
                obj.FadeTick();
                return;
            }
            setTimeout(obj.Tick, obj.time);
        };
        obj.Clear									= function(){
            obj.opacity								= 0;
            obj.progressPos							= 100;
            obj.element.remove();
            obj										= null;
            return;
        };
        obj.FadeTick								= function(){
            obj.opacity								= ((obj.opacity * 100) - obj.fadeInterval) / 100;
            if(obj.opacity <= 0){
                obj.element.remove();
                obj									= null;
                return;
            }
            obj.element.style.opacity				= obj.opacity;
            setTimeout(obj.FadeTick, (obj.fadeTime / obj.fadeTicks));
        };
        obj.Tick									= function(){
            obj.progressPos							+= obj.progressIncrement;
            obj.progress.style.width				= obj.progressPos+"%";
            obj.StartWait();
        };
        obj.Show();
        return obj;
    }
</script>
@if (Session::has('success'))
    <script>
        Notification("green", "done", '{!! Session::get("success") !!}', "Success!");
    </script>
@endif

@if (Session::has('error'))
    <script>
        Notification("red", "report", '{!! Session::get("error") !!}', "Error.");
    </script>
@endif

@if (Session::has('info'))
    <script>
        Notification("blue", "info", '{!! Session::get("info") !!}', "Information");
    </script>
@endif