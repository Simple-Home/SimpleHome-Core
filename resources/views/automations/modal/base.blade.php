 <div class="automation-content">
     <div class="row">
         <div class="col mb-3">
             <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start"
                 data-url="{{ route('automations.tasks') }}">
                 <i class="fas fa-toggle-on pr-2 me-2" aria-hidden="true"></i>Manual
             </button>
         </div>
     </div>
     <div class="row">
         <div class="col">
             <div class="btn-group-vertical  w-100">
                 <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                     data-url="#">
                     <i class="fas fa-cloud-sun pr-2 me-2" aria-hidden="true"></i>Weather
                 </button>
                 <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                     data-url="#">
                     <i class="fas fa-map-marker pr-2 me-2" aria-hidden="true"></i>Location
                 </button>
                 <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                     data-url="#">
                     <i class="fas fa-hourglass-half pr-2 me-2" aria-hidden="true"></i>Schedule
                 </button>
                 <button type="button" class="automation-type btn btn-primary btn-lg w-100 text-start disabled"
                     data-url="#">
                     <i class="fas fa-sync pr-2 me-2" aria-hidden="true"></i>Device Status Change
                 </button>
             </div>
         </div>
     </div>
 </div>
