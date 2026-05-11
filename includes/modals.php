<!-- Feedback Modal -->
<div class="modal fade" id="feedbacksModal" tabindex="-1" role="dialog" aria-labelledby="feedbacksModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; border: none;">
                <h5 class="modal-title" id="feedbacksModalLabel" style="color: #fff; font-weight: 600;">
                    <i class="fa fa-comment" style="margin-right: 8px; color: #a78bfa;"></i> Submit Feedback
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addFeebacks">
                <div class="modal-body" style="padding: 28px;">
                    <div class="form-group">
                        <label style="font-weight: 500; font-size: 13px; color: #374151; margin-bottom: 6px;">Your Identity</label>
                        <select name="asMe" class="form-control" required style="border-radius: 8px; padding: 10px 14px; border: 1.5px solid #e5e7eb;">
                            <option value="">-- Choose --</option>
                            <option value="anonymous">Anonymous</option>
                            <option value="<?php echo $selExmneeData['exmne_fullname']; ?>"><?php echo $selExmneeData['exmne_fullname']; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 500; font-size: 13px; color: #374151; margin-bottom: 6px;">Your Feedback</label>
                        <textarea name="myFeedbacks" class="form-control" rows="5" placeholder="Share your thoughts, suggestions, or concerns..." required style="border-radius: 8px; padding: 12px 14px; border: 1.5px solid #e5e7eb; resize: vertical;"></textarea>
                    </div>
                    <p style="font-size: 12px; color: #9ca3af; margin: 0;"><i class="fa fa-info-circle"></i> You can submit a maximum of 3 feedbacks.</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb;">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>