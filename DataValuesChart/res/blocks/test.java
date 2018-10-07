import java.io.File;

public class Test {

    public static void main(String[] args) {
        // �J�����g�f�B���N�g���擾
        String path = new File(".").getAbsoluteFile().getParent();

        //File�N���X�̃I�u�W�F�N�g�𐶐�����
        File dir = new File(path);
        
        //listFiles���\�b�h���g�p���Ĉꗗ���擾����
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