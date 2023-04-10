<div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-3">
            <svg class="my-3 card-img" width="80" height="80" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z" fill="#6875F5"></path><path d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z" fill="#6875F5"></path></svg>
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="loginUser">
                        <div class="form-group my-2 mx-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" wire:model.defer="email" name="email" id="email" class="form-control @error('email')is-invalid @enderror" placeholder="john@example.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                              @enderror
                        </div>
                        <div class="form-group my-3 mx-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" wire:model.defer="password" name="password" id="password" class="form-control @error('password')is-invalid @enderror" placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                              @enderror
                        </div>
                        <div class="form-check my-3 mx-2">
                            <input class="form-check-input" type="checkbox" id="remember" wire:model.defer="remember">
                            <label class="form-check-label" for="remember">
                              Remember me
                            </label>
                          </div>
                        <div class="d-grid gap-2 d-md-flex align-items-center justify-content-end">
                            <a href="#" class="text-secondary text-small me-md-2">Forgot your password?</a>
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
