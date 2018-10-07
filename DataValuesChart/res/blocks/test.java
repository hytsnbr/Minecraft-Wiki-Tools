import java.io.File;

public class Test {

    public static void main(String[] args) {
        // カレントディレクトリ取得
        String path = new File(".").getAbsoluteFile().getParent();

        //Fileクラスのオブジェクトを生成する
        File dir = new File(path);
        
        //listFilesメソッドを使用して一覧を取得する
        File[] list = dir.listFiles();
        
        String name, tmp = "";
        for(File i : list){
            name = i.getName();
            tmp = name.replace("_", " ").toLowerCase();
            i.renameTo(new File(tmp));
            System.out.println(name + " -> " + tmp);
        }
        System.out.println("\nFinish");
    }
}