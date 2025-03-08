{
  pkgs ? import <nixpkgs> { },
}:

pkgs.mkShell {
  buildInputs = with pkgs; [
    python312Full
    python312Packages.python-dotenv
    python312Packages.pandas
    python312Packages.pymysql
    python312Packages.openpyxl
  ];
  shellHook = ''
    echo "Среда проекта активирована"
  '';
}
