<form action="" method="POST" >
                <div class="modal-body">
                <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">User Fullname</span>
                        <input type="text" name="name" value="<?= $row1['username']?>" class="form-control" aria-label="Course title" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">User Email</span>
                        <input type="email" name="useremail" value="<?= $row1['useremail']?>" class="form-control" aria-label="Course title" aria-describedby="inputGroup-sizing-sm">
                        <div class="error-message visible " style="margin-top:-10px; margin-bottom:10px"><?= $error ?></div>

                      </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
                        <input type="password" name="password" value="" class="form-control" aria-label="Course title" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Confirm Password</span>
                        <input type="password" name="cpassword" value="" class="form-control" aria-label="Course title" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Role</span>
                        <select name="role" class="form-control"  aria-describedby="inputGroup-sizing-sm" required>
                          <option value=""> ---- select role ---- </option>
                          <option value="1" <?= ($row1['user_role']) == '1' ? 'selected': '' ?> >Admin</option>
                          <option value="2" <?= $row1['user_role'] == '2' ? 'selected': '' ?> >Regular user</option>
                        </select>
                    </div>
                    <div class="error-message visible " style="margin-top:-10px; margin-bottom:10px"><?= $error ?></div>
 
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="uid" value="<?=  $row1['id'] ?? '' ?>" >
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>