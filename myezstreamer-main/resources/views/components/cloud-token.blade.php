<div class="pb-8 pt-6">
  <div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            Your Cloud Token
          </h3>
          <p class="mt-1 text-sm text-gray-600">Paste your cloud token from <a class="font-bold" href="https://myezstreamer.com">myEZstreamer.com</a> here to allow cloud management of your stream configurations.</p>
        </div>
      </div>
      <div class="shadow-lg mt-5 md:mt-0 md:col-span-2">
        <form action="" method="POST">
          @csrf
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <input type="hidden" name="id" id="id" value="">
                <div class="col-span-6 ">
                  <script>
                      function toggePassword() {
                          var upass = document.getElementById('cloud_token');
                          var toggleBtn = document.getElementById('toggleBtn');
                          if (upass.type == "password") {
                              upass.type = "text";
                              toggleBtn.value = "Hide token";
                          } else {
                              upass.type = "Password";
                              toggleBtn.value = "Show token";
                          }
                      }
                  </script>                  
                  <label for="cloud_token" class="block text-sm font-medium text-gray-700">Cloud Token</label>
                  <input value="<?= env('CLOUD_API_KEY');?>" type="password" name="cloud_token" id="cloud_token" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                  <input class="hover:cursor-pointer hover:font-semibold" type ="button" id="toggleBtn" value="Show token" onclick="toggePassword()">
                </div>   
              </div>
            </div>
          </div>
          <div class="grid grid-cols-4 bg-indigo-100">
            <div class="col-span-2 2xl:col-span-1"> 
              <div class="px-4 py-3 2xl:py-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
