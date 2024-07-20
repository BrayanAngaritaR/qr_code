@if (Session::has('info'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   const Toast = Swal.mixin({
      toast: true
      , position: 'top-end'
      , showConfirmButton: false
      , timer: 3000
      , timerProgressBar: true
      , didOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
   })

   Toast.fire({
      icon: '{{ Session::get('info')[0] }}', 
		title: '{{ Session::get('info')[1] }}'
   })
</script>
@endif