
<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title?></h1>
			<p class="Location__text">회원에 대한 설정을 적용할 수 있습니다</p>
		</div>
		<div class="pt10"></div>
		<?php 
			$attr = array('class' => 'form-horizontal', 'id'=>'frm');
			echo form_open('', $attr); 
		?>
		<?php echo alert_error($errors); ?>
		<!-- board_write_area -->
		<div class="Form">
			<?php if($view == null){ ?>
			<input type="hidden" name="mb_id_chk" id="mb_id_chk" value="<?php echo ft_set_value($view, 'mb_id_chk'); ?>" />
			<?php }else{ ?>
			<input type="hidden" name="mb_idx" value="<?php echo ft_set_value($view,'mb_idx'); ?>" />
			<?php } ?>
			<div class="Form__group">
				<label for="mb_id" class="Form__label">아이디</label>
				<div class="Form__data">
					<?php if($view == null){?>
					<input type="text" name="mb_id" />
					<a href="javascript:;" class="Button Button__basic" id="btnCheckId">중복확인</a>
					<?php }else{ ?>
					<input type="text" name="mb_id" value="<?php echo ft_set_value($view,'mb_id'); ?>" readonly="readonly"  />
					<?php } ?>
				</div>
			</div>
			<div class="Form__group">
				<label for="mb_name" class="Form__label">이름</label>
				<div class="Form__data">
					<input type="text" name="mb_name" value="<?php echo ft_set_value($view, 'mb_name'); ?>" <?php echo $view == null ? "" : "readonly"; ?> />
				</div>
			</div>
			<?php if($view == null ){?>
			<div class="Form__group">
				<label for="mb_name" class="Form__label">비밀번호</label>
				<div class="Form__data">
					<input type="password" name="mb_passwd" value="<?php echo ft_set_value($view, 'mb_passwd'); ?>" />
				</div>
			</div>
			<div class="Form__group">
				<label for="mb_name" class="Form__label">비밀번호확인</label>
				<div class="Form__data">
					<input type="password" name="mb_re_passwd" value="<?php echo ft_set_value($view, 'mb_re_passwd'); ?>" />
				</div>
			</div>
			<?php }else{ ?>
			<div class="Form__group">
				<label for="mb_name" class="Form__label">비밀번호재설정</label>
				<div class="Form__data">
					<input type="text" name="mb_passwd" />
					변경일 : <?php echo $view->mb_passwddate; ?>
				</div>				
			</div>
			<?php } ?>
			<div class="Form__group">
				<label for="mb_level" class="Form__label">권한</label>
				<div class="Form__data">
					<?php echo ft_dropdown_box('mb_level', $level_list, array(ft_set_value($view, 'mb_level'))); ?>
				</div>
			</div>

			<div class="Form__group">
				<label for="mg_idx" class="Form__label">부서</label>
				<div class="Form__data">
					<?php echo ft_dropdown_box('mb_group', $group_list, array(ft_set_value($view, 'mb_group'))); ?>
				</div>
			</div>

			<div class="Form__group">
				<label for="mb_phone" class="Form__label">전화번호</label>
				<div class="Form__data">
					<input type="text" name="mb_phone" value="<?php echo ft_set_value($view, 'mb_phone'); ?>" />	
				</div>
			</div>

			<div class="Form__group">
				<label for="mb_email" class="Form__label">이메일</label>
				<div class="Form__data">
					<input type="text" name="mb_email" value="<?php echo ft_set_value($view, 'mb_email'); ?>" />
				</div>
			</div>
			<?php if($view != null){ ?>
			<div class="Form__group">
				<div class="Form__label">등록일</div>
				<div class="Form__data">
					<div class="checkbox">
						<?php echo $view-> mb_regdate; ?>
					</div>
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">최종접속일</div>
				<div class="Form__data">
					<div class="checkbox">
						<?php echo $view-> mb_latestdate ; ?>
					</div>
				</div>
			</div>
			<?php if( $view -> mb_state == 0 ){ ?>
			<div class="Form__group">
				<div class="Form__label">탈퇴일</div>
				<div class="Form__data">
					<div class="checkbox">
						<?php echo $view -> mb_leavedate ?>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="Form__group">
				<div class="Form__label">회원 설정</div>
				<div class="Form__data">
					<input type="hidden" name="mb_state" value="<?php echo $view != null ? $view->mb_state : ""; ?>" />
					<button class="Button Button__update" id="btnState" data-value="<?php echo $view->mb_state; ?>"><?php echo $view->mb_state == 0 ? "재가입처리": "탈퇴처리"; ?></button>
					<button class="Button Button__delete" id="btnDeleteMember" data-value="<?php echo $view->mb_idx; ?>">영구삭제</button>
				</div>
			</div>
			<?php } ?>
			</div>
			<div class="pt10"></div>
			<!-- board_write_bottom -->
			<div class="Button__group right">
				<a href="<?php echo $this->list_href."?".$this->query; ?>" class="Button Button__basic">목록</a>
				<button id="btnSubmit" class="Button Button__update"><?php echo $view == null ? "입력" : "수정"; ?></button>
			</div>
			<!-- //board_write_bottom -->	
		</div>
		<!-- //board_write_area -->
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		member.init();
	});
	var member = {
		init : function(){
			var that = this;
			this.mb_id_reset();
			//삭제
			$("#btnDeleteMember").on("click", function(e){
				e.preventDefault();
				that.delete();
				if( confirm("해당 회원을 영구삭제하시겠습니까?") ){
					$("#frm").attr("action", "/setting/member/delete");
					$("#frm").submit();
				}
			});
			$("#btnState").on("click", function(e){
				e.preventDefault();
				that.state();
			});
	
			//수정, 등록
			$("#btnSubmit").on("click", function(e){
				e.preventDefault();
				that.write();
			});

			//아이디중복확인
			$("#btnCheckId").on('click', function(e){
				e.preventDefault();
				that.check_member_id();
			})		
		},
		mb_id_reset : function(){
			$('input[name="mb_id"]').change(function(){
				$('input[name="mb_id_chk"]').val('false');
			});
		},
		check_member_id : function(){
			var mb_id = $('input[name="mb_id"]');
			var mb_id_chk = $('input[name="mb_id_chk"]');
			if( mb_id.val() != '' ){
				$.ajax({
					method : 'get',
					url : "/setting/member/check_member_id",
					data : {
						'mb_id' : mb_id.val()
					}
				}).done(function(data){
					if( data.result === 'false' ){
						alert('사용가능합니다.');
						mb_id_chk.val('true');
						$('input[name="mb_name"]').focus();
					}else{
						alert('중복된 아이디 입니다.');
						mb_id_chk.val('false');
						$('input[name="mb_id"]').focus();
					}
				});
			}else{
				alert("아이디를 입력해주세요");
				mb_id.focus();
			}
			return false;
		},
		delete : function(){
			if( confirm("해당 회원을 영구삭제하시겠습니까?") ){
				$("#frm").attr("action", "/setting/member/delete");
				$("#frm").submit();
			}	
		},
		state : function(){
			if( $("input[name='mb_state']").val() == 1 ){
				$("input[name='mb_state']").val(0);
				if( confirm("해당 회원을 탈퇴처리하시겠습니까?") ){
					$("#frm").attr("action", "/setting/member/state");
					$("#frm").submit();
				}
			}else{
				if( confirm("해당 회원을 재가입 처리하시겠습니까?") ){
					$("input[name='mb_state']").val(1);
					$("#frm").attr("action", "/setting/member/state");
					$("#frm").submit();
				}
			}
		},
		write : function(){
			<?php if($view == null){ ?>
			if( $('input[name="mb_id_chk"]').val() == "" || $('input[name="mb_id_chk"]').val() === 'false'){
				alert("중복확인이 필요합니다.");
				return false;
			}
			<?php } ?>
			$("#frm").submit();
		}
	}
</script>

