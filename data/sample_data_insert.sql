INSERT INTO company(company_name, created_at, updated_at) values('ERI編集部', now(), now());

INSERT INTO admin_user(user_name, is_staff, created_at, updated_at) values('みどり', 1, now(), now());
INSERT INTO admin_user(user_name, is_staff, created_at, updated_at) values('梨枝', 1, now(), now());
INSERT INTO admin_user(user_name, is_staff, created_at, updated_at) values('小夏', 1, now(), now());
INSERT INTO admin_user(user_name, is_staff, created_at, updated_at) values('創平', 1, now(), now());
INSERT INTO admin_user(user_name, company_id, created_at, updated_at) values('草太', 1, now(), now());
INSERT INTO admin_user(user_name, company_id, created_at, updated_at) values('あゆみ', 1, now(), now());

INSERT INTO admin_role(role_code,role_name, is_staff, created_at, updated_at) values('admin', 'システム管理社', 1, now(), now());
INSERT INTO admin_role(role_code,role_name, is_staff, created_at, updated_at) values('staff', '担当者', 1, now(), now());
INSERT INTO admin_role(role_code,role_name, is_staff, created_at, updated_at) values('editor', '外部ライター', 0, now(), now());

INSERT INTO admin_permission(role_id, role_code, 
  can_preview_create, can_preview_update, can_preview_delete, 
  can_create, can_read, can_update, can_delete, created_at, updated_at)values(1, 'admin', 
1, 1, 1, 1, 1, 1, 1, now(), now());
INSERT INTO admin_permission(role_id, role_code, 
  can_preview_create, can_preview_update, can_preview_delete, 
  can_create, can_read, can_update, can_delete, created_at, updated_at)values(2, 'staff', 
0, 0, 0, 0, 1, 0, 0, now(), now());
INSERT INTO admin_permission(role_id, role_code, 
  can_preview_create, can_preview_update, can_preview_delete, 
  can_create, can_read, can_update, can_delete, created_at, updated_at)values(3, 'editor', 
1, 1, 1, 0, 1, 0, 0, now(), now());

INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(1, 1, null, now(), now());
INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(2, 1, null, now(), now());
INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(3, 2, null, now(), now());
INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(4, 2, null, now(), now());
INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(5, 3, 1, now(), now());
INSERT INTO admin_assign(admin_user_id, role_id, company_id, created_at, updated_at) values
(6, 3, 1, now(), now());

INSERT INTO article(title, contents, publish_status, created_at, updated_at) VALUES
('てすとタイトル', 'はろう ZfcRbac', 1, now(), now());
