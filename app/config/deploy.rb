set :application, "randos.maat8.fr"
set :domain,      "maat8.fr"
set :deploy_to,   "/srv/www/#{application}"
set :app_path,    "app"

set :repository,  "https://github.com/maat8/mille-etangs.git"
set :branch, "develop"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set :user, "capifony"
default_run_options[:pty] = true
set :use_sudo, false
set :webserver_user, "www-data"

set :use_composer, true
set :update_vendors, true
set :dump_assetic_assets, true

set :shared_files, ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]

set :writable_dirs, ["app/cache", "app/logs"]

set :keep_releases,  3
after "deploy", "deploy:cleanup"

#logger.level = Logger::MAX_LEVEL