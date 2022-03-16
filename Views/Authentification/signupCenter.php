    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Register</h3>
                <form method="POST" action="/Authentification/Auth_controller/verify_signup">
                <div class="form-group">
                    <label>First name</label>
                    <input type="text" placeholder="First name" name="firstname" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Last name</label>
                    <input type="text" placeholder="Last name" name="lastname" class="form-control p_input">
                  </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email@gmail.com" name="email" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" placeholder="Username" name="username" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="password" name="password" class="form-control p_input">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-facebook col me-2">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p class="sign-up text-center">Already have an Account?<a href="#"> Sign Up</a></p>
                  <p class="terms">By creating an account you are accepting our<a href="#"> Terms & Conditions</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../template/assets/js/misc.js"></script>
